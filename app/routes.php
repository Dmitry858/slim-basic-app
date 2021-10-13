<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function(App $app) {
    $app->get('/page', function (Request $request, Response $response) {
        $title = 'Внутренняя страница';
        return view($response, 'page', compact('title'));
    });

    $app->get('/', function (Request $request, Response $response) {
        return view($response, 'home');
    });
};
