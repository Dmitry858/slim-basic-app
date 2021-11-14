<?php

namespace App\Controllers;

use Slim\App;
use Symfony\Component\HttpFoundation\Session\Session;

class Controller
{
    protected $app;
    protected $csrfNameKey;
    protected $csrfValueKey;
    protected $session;

    public function __construct(App $app)
    {
        $csrf = $app->getContainer()->get('csrf');
        $this->app = $app;
        $this->csrfNameKey = $csrf->getTokenNameKey();
        $this->csrfValueKey = $csrf->getTokenValueKey();

        $this->session = new Session();
    }
}