@extends('layouts.app')

@section('content')
    <div class="content">
        <h1 class="text-center">{{ $title }}</h1>
        <div>{!! $content !!}</div>
    </div>
@endsection
