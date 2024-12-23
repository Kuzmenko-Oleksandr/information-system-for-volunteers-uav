@extends($layout)


@section('content')
    <div class="content-wrapper">
        <section class="content mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="card-header bg-dark messages mr-1 h-100" style="width: calc(50% - 10px);">
                        <h2>Повідомлення</h2>
                        <ul class="list-group list-group-flush">
                            @foreach($messages->unique(function ($message) {
                                return min($message->sender_id, $message->receiver_id) . '_' . max($message->sender_id, $message->receiver_id);
                            }) as $message)
                                @php
                                    $otherUser = $message->sender_id === auth()->id() ? $message->receiver : $message->sender;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('messages.conversation', $otherUser->id) }}" class="text-dark">
                                        <i class="fas fa-comments mr-2"></i> Переписка з {{ $otherUser->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-header bg-dark messages ml-1" style="width: calc(50% - 10px)">

                        <h2>Запити на переписку</h2>
                        <!-- Список запитів -->
                        @foreach($requests as $request)
                            <div>
                                <p><strong>Від: </strong>{{ $request->sender->name }}</p>
                                <div class="row">

                                    <form class="mr-2" action="{{ route('messages.request.accept', $request->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success" type="submit">Підтвердити</button>
                                    </form>
                                    <form action="{{ route('messages.request.reject', $request->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Відхилити</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
