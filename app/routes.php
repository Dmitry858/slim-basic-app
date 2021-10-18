<?php
use Slim\App;
use App\Controllers\MainController;

return function(App $app)
{
    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
