<ul class="navigation">
    <li><a href="/">Главная</a></li>
    <li><a href="/about">О компании</a></li>
    @if (\App\Support\Auth::guest())
        <li><a href="/register">Регистрация</a></li>
        <li><a href="/login">Вход</a></li>
    @else
        <li><a href="/logout">Выход</a></li>
    @endif
</ul>