<?php

namespace App\Middleware;

use Slim\App;

class Middleware
{
    public function init(App $app)
    {
        $app->addErrorMiddleware(
            config('middleware.error.displayErrorDetails'),
            config('middleware.error.logErrors'),
            config('middleware.error.logErrorDetails')
        );

        /**
         * CSRF protection.
         */
        $app->add($app->getContainer()->get('csrf'));
    }
}