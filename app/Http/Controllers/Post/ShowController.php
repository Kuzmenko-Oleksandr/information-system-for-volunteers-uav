<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\MessageRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShowController extends BaseController
{
    public function __invoke(Post $post)
    {
        $user = Auth::user();
        $receiver = $post->user;

        if ($user !== null && ($user->id === $receiver->id || $user->id === null || $user->id === '')) {
            $showMessageButton = false;
        } elseif ($user == null){
            $showMessageButton = false;
        } else {
            // Проверяем статус запроса переписки
            $existingRequest = MessageRequest::where('sender_id', $user->id)
                ->where('receiver_id', $receiver->id)
                ->first();

            if ($existingRequest) {
                if ($existingRequest->status === MessageRequest::STATUS_ACCEPTED) {
                    $showMessageButton = 'message';
                } elseif ($existingRequest->status === MessageRequest::STATUS_REJECTED) {
                    $showMessageButton = 'request';
                } else {
                    $showMessageButton = 'pending';
                }
            } else {
                $showMessageButton = 'request';
            }
        }

        $date = Carbon::parse($post->created_at);
        return view('post.show', compact('post', 'receiver', 'date', 'showMessageButton'));
    }
}

