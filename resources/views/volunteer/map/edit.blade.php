@extends('volunteer.layouts.main')
@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-5">
            <div class="container-fluid">
                <h1>Редагувати маркер</h1>
                <!-- Форма редагування маркера -->
                <form action="{{ route('volunteer.marker.update', $marker->id) }}" method="POST" class="col-4">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="title">Заголовок</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ $marker->title }}" required>
                        @error('title')
                        <div class="text-danger">Введіть заголовок</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Опис</label>
                        <textarea name="description" id="summernote" required>{{ $marker->description }}</textarea>
                        @error('description')
                        <div class="text-danger">Введіть опис</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lat">Широта</label>
                        <input type="text" class="form-control" name="lat" id="lat" value="{{ $marker->lat }}" required>
                        @error('lat')
                        <div class="text-danger">Введіть широту</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="lng">Довгота</label>
                        <input type="text" class="form-control" name="lng" id="lng" value="{{ $marker->lng }}" required>
                        @error('lng')
                        <div class="text-danger">Введіть довготу</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="post">Пости</label>
                        <select name="post_id" id="post" class="form-control">
                            @foreach($posts as $post)
                                <option value="{{ $post->id }}" {{ $post->id == $marker->post_id ? 'selected' : '' }}>
                                    {{ $post->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('post_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-primary" value="Оновити">
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
