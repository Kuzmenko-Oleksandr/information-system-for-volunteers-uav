@extends('layouts.main')

@section('content')
    <main class="blog-post">
        <div class="container">
            @if (
                $post->visibility === 'all' ||
                ($post->visibility === 'registered' && auth()->check()) ||
                ($post->visibility === 'admin_volunteer' && auth()->check() && in_array(auth()->user()->role, ['admin', 'volunteer']))
            )
                <h1 class="edica-page-title" data-aos="fade-up">{{ $post->title }}</h1>

                <p class="edica-blog-post-meta" data-aos="fade-up" data-aos-delay="200">
                    {{ $date->translatedFormat('F') }} {{ $date->day }}, {{ $date->year }} • {{ $date->format('H:i') }}
                    • {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                </p>

                <p class="edica-blog-post-meta" data-aos="fade-up" data-aos-delay="200">
                    Автор: {{ $post->user->name }}</p>

                @if(auth()->check() && auth()->user()->id !== $post->user->id)
                    @if(auth()->user()->role !== 0 && auth()->user()->role !== 2)
                        @if($showMessageButton === 'request')
                            <form action="{{ route('messages.request', $receiver->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mb-5">Відправити запит на переписку</button>
                            </form>
                        @elseif($showMessageButton === 'message')
                            <a href="{{ route('messages.conversation', $receiver->id) }}" class="btn btn-primary mb-5">Відправити повідомлення</a>
                        @elseif($showMessageButton === 'pending')
                            <p>Запит на переписку очікує підтвердження</p>
                        @endif
                    @else
                        <a href="{{ route('messages.conversation', $receiver->id) }}" class="btn btn-primary mb-5">Відправити повідомлення</a>
                    @endif
                @endif


                <section class="blog-post-featured-img text-center" data-aos="fade-up" data-aos-delay="300" >
                    <img src="{{ asset('storage/' . $post->main_image) }}" alt="featured image" style="width: -webkit-fill-available;">
                </section>

                <section class="post-content">
                    <div class="row">
                        <div class="col-lg-9 mx-auto">
                            {!! $post->content !!}
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        {{-- Лайк поста --}}
                        <section class="py-3">
                            @auth
                                <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="border-0 bg-transparent">
                                        <i class="{{ auth()->user()->likedPosts->contains($post->id) ? 'fas' : 'far' }} fa-heart"></i>
                                    </button>
                                </form>
                            @endauth

                            @guest
                                <div>
                                    <span>{{ $post->liked_users_count }}</span>
                                    <i class="far fa-heart"></i>
                                </div>
                            @endguest
                        </section>

                        {{-- Список комментариев --}}
                        <section class="comment-list mb-5">
                            <h2 class="section-title mb-5" data-aos="fade-up">Коментарі ({{ $post->comments->count() }}
                                )</h2>
                            @foreach($post->comments as $comment)
                                @if ($comment->user)
                                    <div class="comment-text mb-3">
                                        <span class="username">
                                            {{ $comment->user->name }}
                                            <span
                                                class="text-muted float-right">{{ $comment->dateAsCarbon->locale('uk')->diffForHumans() }}</span>
                                        </span>
                                        {{ $comment->message }}
                                    </div>
                                @endif
                            @endforeach
                        </section>

                        {{-- Форма добавления комментария --}}
                        @auth
                            <section class="comment-section">
                                <h2 class="section-title mb-5" data-aos="fade-up">Написати коментар</h2>
                                <form action="{{ route('post.comment.store', $post->id) }}" method="post">
                                    @csrf
                                    <div class="form-group" data-aos="fade-up">
                                        <textarea name="message" class="form-control" placeholder="Твій коментар"
                                                  rows="10"></textarea>
                                    </div>
                                    <div class="form-group" data-aos="fade-up">
                                        <input type="submit" value="Відправити коментар" class="btn btn-warning">
                                    </div>
                                </form>
                            </section>
                        @endauth
                    </div>
                </div>
            @else
                <div class="alert alert-warning mt-5" role="alert">
                    У вас немає доступу до даного поста
                </div>
            @endif
        </div>
    </main>
@endsection
