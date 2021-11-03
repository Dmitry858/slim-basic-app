<?php
use Slim\App;
use App\Controllers\MainController;
use App\Controllers\RegisterController;
use App\Controllers\LoginController;

return function(App $app)
{
    $app->get('/register', [RegisterController::class, 'show']);

    $app->post('/register', [RegisterController::class, 'store']);

    $app->get('/login', [LoginController::class, 'show']);

    $app->post('/login', [LoginController::class, 'store']);

    $app->get('/logout', [LoginController::class, 'logout']);

    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
