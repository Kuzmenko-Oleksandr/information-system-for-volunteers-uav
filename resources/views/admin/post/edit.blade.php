@extends('admin.layouts.main')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content mt-5">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <h6>Редагування посту</h6>
                </div>
                <form action="{{ route('admin.post.update', $post->id) }}" method="POST" class="col-4" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Назва посту" value="{{ $post->title }}">
                        @error('title')
                        <div class="text-danger">Використовуйте це поле </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <textarea name="content" id="summernote">{{ $post->content }}</textarea>
                        @error('content')
                        <div class="text-danger">Використовуйте дане поле</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Фото превью</label>
                        <div>
                            <img src="{{ url('storage/' . $post->preview_image) }}" alt="preview_image" class="w-25">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="preview_image">
                                <label for="exampleInputFile" class="custom-file-label">Оберіть зображення для превью</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Додати фото</span>
                            </div>
                        </div>
                        @error('preview_image')
                        <div class="text-danger">Використовуйте дане поле</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Головне фото</label>
                        <div>
                            <img src="{{ url('storage/' . $post->main_image) }}" alt="main_image" class="w-25">
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="main_image">
                                <label for="exampleInputFile" class="custom-file-label">Оберіть головне зображення</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Додати фото</span>
                            </div>
                        </div>
                        @error('preview_image')
                        <div class="text-danger">Використовуйте дане поле</div>
                        @enderror
                    </div>
                    <div class="form-group w-50">
                        <label>Оберіть категорію</label>
                        <select name="category_id" id="" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $post->category_id ? 'selected' : '' }}
                                >{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">Використовуйте дане поле</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Оберіть тег або теги</label>
                        <select data-placeholder="Select tags" name="tag_ids[]" multiple="multiple" id="" class="select2 w-100">
                            @foreach($tags as $tag)
                                <option {{ is_array($post->tags->pluck('id')->toArray()) && in_array($tag->id, $post->tags->pluck('id')->toArray()) ? ' selected' : '' }} value="{{ $tag->id }}">{{ $tag->title }}</option>
                            @endforeach
                        </select>
                        @error('tag_ids')
                        <div class="text-danger">Використовуйте дане поле</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Видимість посту</label>
                        <select name="visibility" class="form-control">
                            <option value="all" {{ $post->visibility == 'all' ? 'selected' : '' }}>Відображати всім</option>
                            <option value="registered" {{ $post->visibility == 'registered' ? 'selected' : '' }}>Відображати тільки зареєстрованим користувачам</option>
                            <option value="admin_volunteer" {{ $post->visibility == 'admin_volunteer' ? 'selected' : '' }}>Відображати адміністратору та волонтерам</option>
                        </select>
                        @error('visibility')
                        <div class="text-danger">Виберіть видимість посту</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Виберіть сторінку для відображення</label>
                        <select name="page" class="form-control">
                            <option value="stream" {{ $post->page == 'stream' ? 'selected' : '' }}>Стрічка</option>
                            <option value="volunteer_organizations" {{ $post->page == 'volunteer_organizations' ? 'selected' : '' }}>Волонтерські організації</option>
                            <option value="collections" {{ $post->page == 'collections' ? 'selected' : '' }}>Збори</option>
                        </select>
                        @error('page')
                        <div class="text-danger">Виберіть сторінку для відображення</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Редагувати" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
