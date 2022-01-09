@extends('layouts.app')

@section('content')
    <div class="content">
        @if(count($success) > 0)
            @foreach($success as $value)
                <div class="alert alert-success" role="alert">
                    {{ $value }}
                </div>
            @endforeach
        @endif
        <h1 class="text-center">{{ $title }}</h1>
        @if($user)
            <h2>Привет, {{ $user }}!</h2>
        @endif
        <div>{!! $content !!}</div>
    </div>
@endsection
