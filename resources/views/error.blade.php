@extends('layouts.error')

@section('content')
    <div class="content">
        <h1 class="text-center mt-0">Ошибка {{ $code }}</h1>
        @if($code == 404)
            <p class="text-center">Упс... страница не найдена</p>
        @endif
        <p class="text-center">
            <a href="/">На главную</a>
        </p>
        @if($htmlException)
            {!! $htmlException !!}
        @endif
    </div>
@endsection
