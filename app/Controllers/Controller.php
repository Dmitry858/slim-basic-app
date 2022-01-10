<?php

namespace App\Controllers;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use App\Support\View;

class Controller
{
    protected $app;
    protected $csrfNameKey;
    protected $csrfValueKey;
    protected $session;
    protected $cache;

    public function __construct(App $app)
    {
        $csrf = $app->getContainer()->get('csrf');
        $this->app = $app;
        $this->csrfNameKey = $csrf->getTokenNameKey();
        $this->csrfValueKey = $csrf->getTokenValueKey();
        $this->session = $app->getContainer()->get('session');
        $this->cache = $app->getContainer()->get('cache');
    }

    protected function getCsrf($request): array
    {
        $csrf = [
            $this->csrfNameKey => $request->getAttribute($this->csrfNameKey),
            $this->csrfValueKey => $request->getAttribute($this->csrfValueKey),
        ];
        return $csrf;
    }

    protected function view(Response $response, $template, $with = []): Response
    {
        $view = new View($this->app);
        return $view->get($response, $template, $with);
    }
}