@extends('layouts.app')

@section('content')
    <div class="content">
        @if(count($errors) > 0)
            @foreach($errors as $error)
                <p>{{ $error }}</p>
            @endforeach
        @endif
        <h1>Авторизация</h1>
        <form method="POST" action="/login">
            {{ csrf_html($csrf) }}
            <input type="email" name="email" placeholder="Email" required />
            <br><br>
            <input type="password" name="password" placeholder="Пароль" required />
            <br><br>
            <button type="submit">Войти</button>
        </form>
    </div>
@endsection
