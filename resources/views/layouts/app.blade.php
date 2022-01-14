<!doctype html>
<html class="h-100" lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="d-flex flex-column h-100">
    @include('include.header')
    <div class="container">
        @yield('content')
    </div>
    @include('include.footer')
    <script src="/js/bootstrap.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>