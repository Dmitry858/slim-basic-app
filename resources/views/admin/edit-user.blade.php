@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Редактирование пользователя {{ $user['name'] }}</h1>
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
            <input type="text" name="name" class="form-control" id="name" value="{{ $user['name'] }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $user['email'] }}">
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Новый пароль</label>
            <input type="password" name="new_password" class="form-control" id="new_password">
        </div>
        <div class="mb-3">
            <label for="confirm_new_password" class="form-label">Подтверждение нового пароля</label>
            <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password">
        </div>
        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" name="is_admin" id="is_admin" value="1" @if($user['is_admin'] === 1) checked @endif>
            <label class="form-check-label" for="is_admin">Администратор</label>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ config('admin.path').'/users' }}" class="btn btn-secondary">Отменить</a>
    </form>
@endsection