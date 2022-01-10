<?php

namespace App\Support;

use Slim\App;
use eftec\bladeone\BladeOne;
use Psr\Http\Message\ResponseInterface as Response;

class View
{
    private $cache;

    public function __construct(App $app)
    {
        $this->cache = $app->getContainer()->get('cache');
    }

    public function get(Response $response, $template, $with = []): Response
    {
        $blade = new BladeOne(
            config('blade.views'),
            config('blade.cache'),
            config('blade.mode')
        );
        $response->getBody()->write(
            $blade->run($template, $with)
        );
        return $response;
    }
}