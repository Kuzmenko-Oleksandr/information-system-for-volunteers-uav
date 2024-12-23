@extends('volunteer.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content mt-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-auto mb-3">
                        <a href="{{route('volunteer.post.create')}}" class="btn btn-block btn-primary">Додати пост</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Назва</th>
                                <th>Опис</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <th scope="row">{{ $post->id }}</th>
                                    <td>{{$post->title}}</td>
                                    <td>{{ Str::limit($post->content, 100) }}</td>
                                    <td><a href="{{ route('volunteer.post.edit', $post->id) }}"><i class="fas fa-pencil-alt"></i></a></td>
                                    <td>
                                        <form action="{{ route('volunteer.post.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent">
                                                <i class="fas fa-trash text-danger" role="button"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
