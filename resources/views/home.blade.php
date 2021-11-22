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
        <h1 class="text-center">Главная страница</h1>
        @if($user)
            <h2>Привет, {{ $user }}!</h2>
        @endif
        <p>Далеко-далеко за словесными горами в стране гласных и согласных живут, рыбные тексты. Своего эта обеспечивает предложения возвращайся продолжил? Встретил коварных взобравшись строчка инициал о, первую даль агентство предупредила напоивший. Маленькая, выйти подпоясал.</p>
    </div>
@endsection
