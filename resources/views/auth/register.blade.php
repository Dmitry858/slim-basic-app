@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>Регистрация</h1>
        <form method="POST" action="/register">
            <input type="text" name="name" placeholder="Имя" required />
            <br><br>
            <input type="email" name="email" placeholder="Email" required />
            <br><br>
            <input type="password" name="password" placeholder="Пароль" required />
            <br><br>
            <input type="password" name="confirm_password" placeholder="Пароль ещё раз" required />
            <br><br>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
@endsection
