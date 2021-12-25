<?php

use Slim\App;
use App\Controllers\Admin\AdminController;
use App\Middleware\RedirectIfNotAdminMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $app->group(config('admin.path'), function (RouteCollectorProxy $group) {
        $group->get('/dashboard', [AdminController::class, 'index']);
    })->add(new RedirectIfNotAdminMiddleware());
};
