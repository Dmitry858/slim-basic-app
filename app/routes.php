<?php
use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use eftec\bladeone\BladeOne;

return function(App $app) {
    function view(Response $response, $template, $with = []) {
        $views = __DIR__ . '/../views';
        $cache = __DIR__ . '/../cache';
        $blade = new BladeOne($views, $cache,BladeOne::MODE_DEBUG);
        $response->getBody()->write(
            $blade->run($template, $with)
        );
        return $response;
    };

    $app->get('/page', function (Request $request, Response $response) {
        $title = 'Внутренняя страница';
        return view($response, 'page', compact('title'));
    });

    $app->get('/', function (Request $request, Response $response) {
        return view($response, 'home');
    });
};
