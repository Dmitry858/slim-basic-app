<?php

use Slim\App;
use App\Controllers\MainController;
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\ResetPasswordController;
use App\Middleware\RedirectIfAuthMiddleware;
use App\Middleware\RedirectIfGuestMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $csrf = $app->getContainer()->get('csrf');

    $app->group('/', function (RouteCollectorProxy $group) {
        $group->get('register', [RegisterController::class, 'show']);
        $group->post('register', [RegisterController::class, 'store']);
        $group->get('login', [LoginController::class, 'show']);
        $group->post('login', [LoginController::class, 'store']);
    })->add(new RedirectIfAuthMiddleware())->add($csrf);

    $app->group('/', function (RouteCollectorProxy $group) {
        $group->get('reset-password', [ResetPasswordController::class, 'send']);
        $group->post('reset-password', [ResetPasswordController::class, 'store']);
        $group->get('reset-password/confirm', [ResetPasswordController::class, 'confirm']);
        $group->get('reset-password/{key}', [ResetPasswordController::class, 'show']);
        $group->post('reset-password/{key}', [ResetPasswordController::class, 'update']);
    })->add(new RedirectIfAuthMiddleware())->add($csrf);

    $app->get('/logout', [LoginController::class, 'logout'])->add(new RedirectIfGuestMiddleware());

    $app->get('/{slug}', [MainController::class, 'page']);

    $app->get('/', [MainController::class, 'index']);
};
