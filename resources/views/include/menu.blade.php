<ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
    <li class="nav-item"><a class="nav-link" href="/about">О компании</a></li>
    @if (\App\Support\Auth::guest())
        <li class="nav-item"><a class="nav-link" href="/register">Регистрация</a></li>
        <li class="nav-item"><a class="nav-link" href="/login">Вход</a></li>
    @else
        <li class="nav-item"><a class="nav-link" href="/logout">Выход</a></li>
    @endif
</ul>