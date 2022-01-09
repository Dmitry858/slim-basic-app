<!doctype html>
<html class="h-100" lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Административная панель' }}</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    @include('admin.include.header')
    <div class="container-fluid">
        <div class="row">
            @include('admin.include.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pb-5">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="/js/bootstrap.js"></script>
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script src="/js/admin.js"></script>
</body>
</html>