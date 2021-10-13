<?php
/* Global helper functions */
use eftec\bladeone\BladeOne;
use Psr\Http\Message\ResponseInterface as Response;

if (!function_exists('view'))
{
    function view(Response $response, $template, $with = []) {
        $views = __DIR__ . '/../views';
        $cache = __DIR__ . '/../cache';
        $blade = new BladeOne($views, $cache,BladeOne::MODE_DEBUG);
        $response->getBody()->write(
            $blade->run($template, $with)
        );
        return $response;
    };
}