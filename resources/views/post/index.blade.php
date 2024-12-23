@extends('layouts.main')

@section('content')
    <main class="blog">
        <div class="container">
            <h1 class="edica-page-title" data-aos="fade-up">{{ $page === 'stream' ? 'Стрічка' : ($page === 'volunteer_organizations' ? 'Волонтерські організації' : 'Збори') }}</h1>

            <!-- Кнопка для открытия панели -->
            <button class="btn btn-primary mb-5" onclick="toggleFilterPanel()">
                <i class="fa fa-filter"></i> Фільтри
            </button>

            <!-- Боковая панель фильтров -->
            <div id="filterPanel" class="filter-panel">
                <div class="filter-panel-header">
                    <h4>Фільтри</h4>
                    <button type="button" class="close" onclick="toggleFilterPanel()">&times;</button>
                </div>
                <div class="filter-panel-body">
                    <form action="{{ route('post.index', ['page' => $page]) }}" method="GET">
                        <input type="hidden" name="page" value="{{ $page }}">

                        <div class="mb-4">
                            <h5>Категорії</h5>
                            <div class="form-group d-flex flex-wrap">
                                @foreach($categories as $category)
                                    <div class="form-check me-3 mb-2" style="min-width: 150px;">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            name="categories[]"
                                            value="{{ $category->id }}"
                                            id="category_{{ $category->id }}"
                                            {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>Теги</h5>
                            <div class="form-group d-flex flex-wrap">
                                @foreach($tags as $tag)
                                    <div class="form-check me-3 mb-2" style="min-width: 150px;">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            name="tags[]"
                                            value="{{ $tag->id }}"
                                            id="tag_{{ $tag->id }}"
                                            {{ in_array($tag->id, request('tags', [])) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="tag_{{ $tag->id }}">
                                            {{ $tag->title }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Відсортувати</button>
                    </form>
                </div>
            </div>

            <section class="featured-posts-section">
                <div class="row">
                    @foreach($posts as $post)
                        @if ($post->visibility === 'all' || ($post->visibility === 'registered' && auth()->check()) || ($post->visibility === 'admin_volunteer' && auth()->check() && (auth()->user()->role === 0 || auth()->user()->role === 2)))
                            <a href="{{ route('post.show', $post->id) }}" style="color: black; text-decoration: unset;"
                               class="col-md-4 fetured-post blog-post" data-aos="fade-up">
                                <div>
                                    <div class="blog-post-thumbnail-wrapper">
                                        <img src="{{asset('storage/' . $post->preview_image)}}" alt="blog post">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="blog-post-author">Автор: {{ $post->user->name }}</p>
                                        @auth()
                                            <form action="{{ route('post.like.store', $post->id) }}" method="post">
                                                @csrf
                                                <span> {{ $post->liked_users_count }} </span>
                                                <button type="submit" class="border-0 bg-transparent">
                                                    @if (auth()->user()->likedPosts->contains($post->id) )
                                                        <i class="fas fa-heart"></i>
                                                    @else
                                                        <i class="far fa-heart"></i>
                                                    @endif
                                                </button>
                                            </form>
                                        @endauth
                                        @guest()
                                            <div>
                                                <span> {{ $post->liked_users_count }} </span>
                                                <i class="far fa-heart"></i>
                                            </div>
                                        @endguest
                                    </div>
                                    @if ($post->category)
                                        <p class="blog-post-category">{{$post->category->title}}</p>
                                    @endif
                                    <h6 class="blog-post-title">{{ $post->title }}</h6>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="row">
                    <div class="mx-auto">
                        {{ $posts->appends(request()->input())->links() }}
                    </div>
                </div>
            </section>
        </div>
    </main>

    <style>
        .filter-panel {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background-color: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0,0,0,0.5);
            transition: left 0.3s ease;
            z-index: 1045;
            padding: 15px;
        }

        .filter-panel.open {
            left: 0;
        }

        .filter-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .filter-panel-body {
            overflow-y: auto;
        }
    </style>

    <script>
        function toggleFilterPanel() {
            var panel = document.getElementById("filterPanel");
            panel.classList.toggle("open");
        }
    </script>
@endsection
