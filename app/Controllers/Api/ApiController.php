<?php

namespace App\Controllers\Api;

use Slim\App;

class ApiController
{
    protected $cache;

    public function __construct(App $app)
    {
        $this->cache = $app->getContainer()->get('cache');
    }
}