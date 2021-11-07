<?php

namespace App\Controllers;

use Slim\App;

class Controller
{
    protected $app;
    protected $csrfNameKey;
    protected $csrfValueKey;

    public function __construct(App $app)
    {
        $csrf = $app->getContainer()->get('csrf');
        $this->app = $app;
        $this->csrfNameKey = $csrf->getTokenNameKey();
        $this->csrfValueKey = $csrf->getTokenValueKey();
    }
}