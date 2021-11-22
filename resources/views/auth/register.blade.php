@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>Регистрация</h1>
        <div class="form-signup">
            @if(count($errors) > 0)
                @foreach($errors as $error)
                    <div class="alert alert-danger text-center" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <form method="POST" action="/register">
                {{ csrf_html($csrf) }}
                <div class="form-floating">
                    <input class="form-control" id="name" type="text" name="name" placeholder="Имя" required />
                    <label for="name">Имя</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="email" type="email" name="email" placeholder="Email" required />
                    <label for="email">Email</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="password" type="password" name="password" placeholder="Пароль" required />
                    <label for="password">Пароль</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="confirm_password" type="password" name="confirm_password" placeholder="Пароль ещё раз" required />
                    <label for="confirm_password">Пароль ещё раз</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
