<?php
use Slim\App;
use App\Controllers\MainController;
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Middleware\RedirectIfAuthMiddleware;
use App\Middleware\RedirectIfGuestMiddleware;

return function(App $app)
{
    $app->get('/register', [RegisterController::class, 'show'])->add(new RedirectIfAuthMiddleware());

    $app->post('/register', [RegisterController::class, 'store'])->add(new RedirectIfAuthMiddleware());

    $app->get('/login', [LoginController::class, 'show'])->add(new RedirectIfAuthMiddleware());

    $app->post('/login', [LoginController::class, 'store'])->add(new RedirectIfAuthMiddleware());

    $app->get('/logout', [LoginController::class, 'logout'])->add(new RedirectIfGuestMiddleware());

    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
