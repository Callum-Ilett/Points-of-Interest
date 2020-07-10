<?php

use Slim\App;
use Slim\Views\TwigMiddleware;
return function(App $app) {
    // Add routing functionality to Slim. This is not included by default and
    // must be turned on.
    $app->addRoutingMiddleware();

    $app->add(TwigMiddleware::createFromContainer($app));

    // Define Custom Error Handler
    $customErrorHandler = function () use ($app) {
        $response = $app->getResponseFactory()->createResponse();
        $response = $response->withStatus(404);
        return $this->get('view')->render($response, 'error404.twig');
    };

    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    // $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};