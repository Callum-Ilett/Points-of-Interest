<?php

namespace App\Middleware;


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class GuestMiddleware {

    public function __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);

        if(isset($_SESSION['username'])){
            $home = \Slim\Routing\RouteContext::fromRequest($request)->getRouteParser()->urlFor('home');
		    return $response->withHeader('Location', $home)->withStatus(302);
        }

        return $response;

    }

}