@extends('volunteer.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content mt-5">
            <div class="container-fluid">
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
                            <tr>
                                <th scope="row">{{ $post->id }}</th>
                                <td>{{$post->title}}</td>
                                <td>{{$post->content}}</td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
