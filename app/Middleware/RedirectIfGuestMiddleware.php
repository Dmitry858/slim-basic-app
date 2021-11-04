<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Support\Auth;

class RedirectIfGuestMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        if (Auth::guest())
        {
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        return $response;
    }
}