@extends('layouts.app')

@section('content')
    <div class="content">
        <h1 class="text-center">Ошибка {{ $code }}</h1>
        @if($code == 404)
            <p class="text-center">Упс... страница не найдена</p>
        @endif
        @if($htmlException)
            {!! $htmlException !!}
        @endif
    </div>
@endsection
