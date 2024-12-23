<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\MessageRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function createMessageRequest(Request $request, $receiver_id)
    {
        $sender = Auth::user();
        $receiver = User::findOrFail($receiver_id);

        // Проверка ролей отправителя и получателя
        if (in_array($sender->role, [User::ROLE_VOLUNTEER, User::ROLE_ADMIN]) && in_array($receiver->role, [User::ROLE_VOLUNTEER, User::ROLE_ADMIN])) {
            // Создаем сообщение без запроса, если это волонтер или администратор
            Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'content' => $request->input('content', 'Початок переписки'),
            ]);
            return redirect()->route('messages.conversation', $receiver->id)->with('message', 'Переписка створена без запиту на підтвердження.');
        }

        // Если отправитель - обычный пользователь, создаем запрос на подтверждение, если его еще нет
        $existingRequest = MessageRequest::where('sender_id', $sender->id)
            ->where('receiver_id', $receiver->id)
            ->whereIn('status', [MessageRequest::STATUS_PENDING, MessageRequest::STATUS_ACCEPTED])
            ->exists();

        if (!$existingRequest) {
            MessageRequest::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'status' => MessageRequest::STATUS_PENDING,
            ]);
            return back()->with('message', 'Запит на переписку надіслано.');
        }

        return redirect()->route('messages.conversation', $receiver->id)->with('message', 'Переписка вже існує.');
    }

    public function acceptRequest($request_id)
    {
        $messageRequest = MessageRequest::findOrFail($request_id);
        $messageRequest->update(['status' => MessageRequest::STATUS_ACCEPTED]);

        // Создаем сообщение, подтверждающее переписку
        Message::create([
            'sender_id' => $messageRequest->receiver_id,
            'receiver_id' => $messageRequest->sender_id,
            'content' => 'Переписка підтверджена.',
        ]);

        return redirect()->route('messages.conversation', $messageRequest->sender_id)
            ->with('message', 'Запит на переписку підтверджено.');
    }

    public function rejectRequest($request_id)
    {
        $messageRequest = MessageRequest::findOrFail($request_id);
        $messageRequest->update(['status' => MessageRequest::STATUS_REJECTED]);
        return back()->with('message', 'Запит на переписку відхилено.');
    }

    public function index()
    {
        $user = Auth::user();
        $layout = match ($user->role) {
            0 => 'admin.layouts.main',
            1 => 'personal.layouts.main',
            2 => 'volunteer.layouts.main',
            default => 'layouts.main',
        };

        // Получаем все уникальные переписки
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) {
                return $message->sender_id . '_' . $message->receiver_id;
            });

        // Запросы на переписку
        $requests = MessageRequest::where('receiver_id', $user->id)
            ->where('status', MessageRequest::STATUS_PENDING)
            ->get();

        return view('messages.index', compact('messages', 'requests', 'layout'));
    }

    public function showConversation($otherUserId)
    {
        $user = auth()->user();
        $layout = match ($user->role) {
            0 => 'admin.layouts.main',
            1 => 'personal.layouts.main',
            2 => 'volunteer.layouts.main',
            default => 'layouts.main',
        };

        $otherUser = User::findOrFail($otherUserId);

        // Проверка доступа к переписке
        if (!$this->checkPermissionToMessage($otherUser)) {
            return redirect()->route('messages.index')->with('error', 'У вас немає доступу до цього чату.');
        }

        // Получаем все сообщения между пользователями
        $messages = Message::where(function ($query) use ($otherUserId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at')
            ->get();

        $existingRequest = MessageRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $otherUser->id)
            ->where('status', MessageRequest::STATUS_PENDING)
            ->exists();

        return view('messages.conversation', compact('messages', 'existingRequest', 'otherUser', 'layout'));
    }

    private function checkPermissionToMessage($receiver)
    {
        // Если пользователь - волонтер или администратор, доступ разрешен
        if (in_array(auth()->user()->role, [User::ROLE_VOLUNTEER, User::ROLE_ADMIN])) {
            return true;
        }

        // Проверка, есть ли запрос на переписку и он принят
        return MessageRequest::where('sender_id', auth()->id())
            ->where('receiver_id', $receiver->id)
            ->where('status', MessageRequest::STATUS_ACCEPTED)
            ->exists();
    }

    public function sendMessage(Request $request, $receiverId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'content' => $request->input('content'),
        ]);

        return redirect()->route('messages.conversation', $receiverId);
    }

    public function fetchMessages($otherUserId)
    {
        $messages = Message::where(function ($query) use ($otherUserId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $otherUserId);
        })
            ->orWhere(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)
                    ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages, 200);
    }
}
