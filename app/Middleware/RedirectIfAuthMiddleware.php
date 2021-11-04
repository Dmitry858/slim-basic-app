<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Support\Auth;

class RedirectIfAuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        if (Auth::check())
        {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        return $response;
    }
}