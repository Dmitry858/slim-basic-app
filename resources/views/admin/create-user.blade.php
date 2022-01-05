@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Создание нового пользователя</h1>
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
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" class="form-control" id="name" value="" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Подтверждение пароля</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
        </div>
        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="is_admin" id="is_admin" value="1">
            <label class="form-check-label" for="is_admin">Администратор</label>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ config('admin.path').'/users' }}" class="btn btn-secondary">Отменить</a>
    </form>
@endsection