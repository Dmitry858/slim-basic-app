@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Редактирование пункта {{ $item['title'] }}</h1>
    </div>

    @if(count($errors) > 0)
        @foreach($errors as $error)
            <div class="alert alert-danger text-center" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $item['title'] }}" required>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Ссылка</label>
            <input type="text" name="link" class="form-control" id="link" value="{{ $item['link'] }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ config('admin.path').'/menu' }}" class="btn btn-secondary">Отменить</a>
    </form>
@endsection