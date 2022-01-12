<ul class="navbar-nav">
    @if($menu && is_array($menu) && count($menu) > 0)
        @foreach($menu as $item)
            @if(($item['link'] == '/register' || $item['link'] == '/login') && !\App\Support\Auth::guest())
                @continue
            @endif
            @if($item['link'] == '/logout' && \App\Support\Auth::guest())
                @continue
            @endif
            <li class="nav-item"><a class="nav-link" href="{{ $item['link'] }}">{{ $item['title'] }}</a></li>
        @endforeach
    @endif
</ul>