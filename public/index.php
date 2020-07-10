<?php

session_start();

use Slim\Factory\AppFactory;

use DI\Container;

// Autoload classes from vendor
require __DIR__ . '/../vendor/autoload.php';

// Instantiate di container
$container = new Container();

// Set container on app
AppFactory::setContainer($container);

// Create our app
$app = AppFactory::create();

$routeParser = $app->getRouteCollector()->getRouteParser();

// Require config settings
require(__DIR__ . '/../app/config/config.php');

// For the routes to work correctly, you must set your base path.
// This is the relative path of your webspace on the server, including the
// folder you're using but NOT public_html. Here we are assuming the Slim app
// is saved in the 'slim/poi' folder within 'public_html' 
$app->setBasePath(BASE_PATH);

// Set container definitions
$containerDefinitions = require(__DIR__ . '/../app/config/container-definitions.php');
$containerDefinitions($container, $routeParser);

// Add middleware
$middleware = require(__DIR__ . '/../app/config/middleware.php');
$middleware($app);

// Add routes
$routes = require(__DIR__ . '/../app/config/routes.php');
$routes($app);

// Run app
$app->run();
