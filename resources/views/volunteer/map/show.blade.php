@extends('volunteer.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content mt-5">
            <div class="container-fluid">
                <h6>Деталі маркера</h6>
                <p><strong>Місце:</strong> {{ $marker->location }}</p>
                <p><strong>Опис:</strong> {{ $marker->description }}</p>
                <a href="{{ route('volunteer.marker.edit', $marker->id) }}" class="btn btn-warning">Редагувати</a>
                <form action="{{ route('volunteer.marker.destroy', $marker->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Видалити</button>
                </form>
            </div>
        </section>
    </div>
@endsection
