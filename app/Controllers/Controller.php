<?php

namespace App\Controllers;

use Slim\App;

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
}