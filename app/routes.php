<?php
use Slim\App;
use App\Controllers\MainController;
use App\Controllers\RegisterController;

return function(App $app)
{
    $app->get('/register', [RegisterController::class, 'show']);

    $app->post('/register', [RegisterController::class, 'store']);

    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
