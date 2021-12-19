<?php

use Slim\App;
use App\Controllers\Api\ApiUserController;
use App\Middleware\JsonBodyParserMiddleware;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/login', [ApiUserController::class, 'login']);
        $group->get('/users', [ApiUserController::class, 'getAll']);
        $group->get('/users/{id:[0-9]+}', [ApiUserController::class, 'get']);
        $group->post('/users/create', [ApiUserController::class, 'create']);
        $group->post('/users/{id:[0-9]+}', [ApiUserController::class, 'update']);
        $group->delete('/users/{id:[0-9]+}', [ApiUserController::class, 'delete']);
    })->add(new JsonBodyParserMiddleware());
};
