@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Редактирование страницы {{ $page['title'] }}</h1>
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
            <label for="name" class="form-label">Заголовок</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $page['title'] }}" required>
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Слаг</label>
            <input type="text" name="slug" class="form-control" id="slug" value="{{ $page['slug'] }}" required @if($page['slug'] === 'home') readonly @endif>
        </div>
        <div class="mb-3">
            <label for="excerpt" class="form-label">Анонс</label>
            <textarea class="form-control" name="excerpt" id="excerpt" rows="2">{{ $page['excerpt'] }}</textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Содержание</label>
            <textarea class="form-control" name="content" id="content" rows="5">{{ $page['content'] }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ config('admin.path').'/pages' }}" class="btn btn-secondary">Отменить</a>
    </form>
@endsection