<?php

namespace App\Controllers;

use Slim\App;
use Psr\Http\Message\ResponseInterface as Response;
use App\Support\View;
use Illuminate\Pagination\Paginator;

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

        Paginator::currentPageResolver(function ($pageName = 'page') {
            return (int) ($_GET[$pageName] ?? 1);
        });
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