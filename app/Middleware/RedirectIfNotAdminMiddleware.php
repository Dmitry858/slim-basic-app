<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Support\Auth;

class RedirectIfNotAdminMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response = $handler->handle($request);
        if (!Auth::admin())
        {
            return $response->withHeader('Location', '/');
        }

        return $response;
    }
}