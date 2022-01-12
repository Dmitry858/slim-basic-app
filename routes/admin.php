<?php

use Slim\App;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\UserController;
use App\Controllers\Admin\PageController;
use App\Controllers\Admin\MenuController;
use App\Middleware\RedirectIfNotAdminMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $app->group(config('admin.path'), function (RouteCollectorProxy $group) {
        $group->get('/dashboard', [AdminController::class, 'index']);

        $group->get('/users', [UserController::class, 'index']);
        $group->get('/users/{id:[0-9]+}', [UserController::class, 'show']);
        $group->post('/users/{id:[0-9]+}', [UserController::class, 'update']);
        $group->get('/users/create', [UserController::class, 'create']);
        $group->post('/users/create', [UserController::class, 'store']);
        $group->post('/users/delete/{id:[0-9]+}', [UserController::class, 'delete']);

        $group->get('/pages', [PageController::class, 'index']);
        $group->get('/pages/{id:[0-9]+}', [PageController::class, 'show']);
        $group->post('/pages/{id:[0-9]+}', [PageController::class, 'update']);
        $group->get('/pages/create', [PageController::class, 'create']);
        $group->post('/pages/create', [PageController::class, 'store']);
        $group->post('/pages/delete/{id:[0-9]+}', [PageController::class, 'delete']);

        $group->get('/menu', [MenuController::class, 'index']);
        $group->get('/menu/{id:[0-9]+}', [MenuController::class, 'show']);
        $group->post('/menu/{id:[0-9]+}', [MenuController::class, 'update']);
        $group->get('/menu/create', [MenuController::class, 'create']);
        $group->post('/menu/create', [MenuController::class, 'store']);
        $group->post('/menu/delete/{id:[0-9]+}', [MenuController::class, 'delete']);
    })->add(new RedirectIfNotAdminMiddleware());
};
