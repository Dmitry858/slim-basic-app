<?php

namespace App\Middleware;

use Slim\App;
use Tuupola\Middleware\JwtAuthentication;

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
        // $app->add($app->getContainer()->get('csrf')); // register middleware to be executed on all routes

        /**
         * JWT Authentication Middleware.
         */
        $app->add(new JwtAuthentication([
            'path' => config('api.token.path'),
            'ignore' => config('api.token.ignore'),
            'secret' => config('api.token.secret_key'),
            'secure' => config('api.token.secure'),
            'error' => function ($response, $arguments) {
                $data['status'] = 'error';
                $data['message'] = $arguments['message'];
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->getBody()->write(json_encode($data));
            }
        ]));
    }
}