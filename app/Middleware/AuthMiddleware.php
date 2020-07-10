<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware {

    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);

        if(!isset($_SESSION['username'])){
            $register = \Slim\Routing\RouteContext::fromRequest($request)->getRouteParser()->urlFor('auth.register');
		    return $response->withHeader('Location', $register)->withStatus(302);
        }

        return $response;

    }

}