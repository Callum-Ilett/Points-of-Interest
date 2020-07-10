<?php

use DI\Container;

use Slim\Views\Twig;

return function (Container $container) {

    // Set Auth class in container
    $container->set('auth', function(){
        return new \App\Auth\Auth();
    });

    // Set Twig in container
    $container->set('view', function ($container){
        $twig = Twig::create(
            APP_ROOT . '/views',
            ['cache' => false]
        );

        $twig->getEnvironment()->addGlobal('auth', [
            'check' => $container->get('auth')->check(),
            'user' => $container->get('auth')->user(),
            'isAdmin' => $container->get('auth')->isAdmin()
        ]);

        $twig->getEnvironment()->addGlobal('PUBLIC_PATH', PUBLIC_PATH);

        return $twig;
    });

    // ******************* Controllers ****************************************

    // Set HomeController in container for route(/)
    $container->set('HomeController', function ($container) {
        return new \App\Controllers\HomeController($container);
    });

    // Set DiscoverController in container for route(/discover)
    $container->set('DiscoverController', function ($container) {
        return new \App\Controllers\DiscoverController($container);
    });

    // Set PoiController in container for route(/poi/recommend)
    $container->set('PoiController', function ($container) {
        return new \App\Controllers\PoiController($container);
    });

    // Set DasboardController in container for routes(/dashboard)
    $container->set('DashboardController', function ($container) {
        $view = $container->get('view');
        return new \App\Controllers\DashboardController($container, $view);
    });

    // Set ApiController in container for routes 
    $container->set('ApiController', function ($container) {
        return new \App\Controllers\ApiController($container);
    });

    // Set Authentication controller  in container
    $container->set('AuthController', function ($container) {
        return new \App\Controllers\AuthController($container);
    });


	// ******************* Models ****************************************
	$container->set('DashboardModel', function ($container) {
        return new \App\Models\Dashboard();
	});
	
    $container->set('ReviewModel', function ($container) {
        return new \App\Models\Review();
    });

    $container->set('PoiModel', function ($container) {
        return new \App\Models\Poi();
    });

    $container->set('GooglePlacesAPI', function ($container) {
        return new \App\Models\PlacesAPI;
    });

    $container->set('UserModel', function ($container) {
        return new \App\Models\User;
    });
    
};
