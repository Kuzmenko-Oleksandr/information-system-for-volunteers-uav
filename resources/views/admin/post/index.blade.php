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
                    <div class="col-auto mb-3">
                        <a href="{{route('admin.post.create')}}" type="button" class="btn btn-block btn-primary">Додати пост</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <table class="table table-dark">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Назва</th>
                                <th scope="col">Опис</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $post)
                                <tr>
                                    <th scope="row">{{ $post->id }}</th>
                                    <td>{{$post->title}}</td>
                                    <td>{{ Str::limit($post->content, 100) }}</td>
                                    <td><a href="{{ route('admin.post.show', $post->id) }}"><i
                                                class="far fa-eye"></i></a></td>
                                    <td><a href="{{ route('admin.post.edit', $post->id) }}"><i
                                                class="fas fa-pencil-alt"></i></a></td>
                                    <td>
                                        <form action="{{ route('admin.post.delete', $post->id) }}" method="POST">
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
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
