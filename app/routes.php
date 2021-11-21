<?php
use Slim\App;
use App\Controllers\MainController;
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\Api\ApiController;
use App\Controllers\Api\ApiUserController;
use App\Middleware\RedirectIfAuthMiddleware;
use App\Middleware\RedirectIfGuestMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->get('/users', [ApiUserController::class, 'getAll']);
        $group->get('/users/{id:[0-9]+}', [ApiUserController::class, 'get']);
        $group->post('/login', [ApiController::class, 'login']);
    });

    $app->group('/', function (RouteCollectorProxy $group) {
        $group->get('register', [RegisterController::class, 'show']);
        $group->post('register', [RegisterController::class, 'store']);
        $group->get('login', [LoginController::class, 'show']);
        $group->post('login', [LoginController::class, 'store']);
    })->add(new RedirectIfAuthMiddleware())->add($app->getContainer()->get('csrf'));

    $app->get('/logout', [LoginController::class, 'logout'])->add(new RedirectIfGuestMiddleware());

    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
