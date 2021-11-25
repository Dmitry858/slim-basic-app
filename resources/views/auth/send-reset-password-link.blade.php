@extends('layouts.app')

@section('content')
    <div class="content">
        <h1>Восстановление пароля</h1>
        <div class="form-signin">
            @if(count($errors) > 0)
                @foreach($errors as $error)
                    <div class="alert alert-danger text-center" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            <form method="POST" action="/reset-password">
                {{ csrf_html($csrf) }}
                <div class="form-floating">
                    <input class="form-control" id="email" type="email" name="email" placeholder="Email" required />
                    <label for="email">Email</label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Восстановить</button>
            </form>
        </div>
    </div>
@endsection
