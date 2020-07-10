<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

return function(App $app) {

    $app->get('/', 'HomeController:home')->setName('home');

    // Discover poi by region
    $app->get('/discover/region/{region}', 'DiscoverController:getRegion')->setName('discover.region');

    // Discover poi by category
    $app->get('/discover/category/{category}', 'DiscoverController:getCategory')->setName('discover.category');

    // Discover poi in detail
    $app->get('/discover/{poi}', 'DiscoverController:discoverName')->setName('discover.detail');
    $app->post('/discover/{poi}', 'DiscoverController:postReview');

    // Recommend a poi
    $app->post('/recommend', 'PoiController:recommendPoi')->setName('poi.recommend')->add(new AuthMiddleware);

    // Dashboard(add listing, read reviews)
    $app->group('/dashboard', function(RouteCollectorProxy $group){

        $group->get('', 'DashboardController:getDashboard')->setName('dashboard');
    
        $group->get('/add-listing', 'DashboardController:getListing')->setName('dashboard.add-listing');
        $group->post('/add-listing', 'DashboardController:postListing');
    
        $group->get('/reviews', 'DashboardController:getReviews')->setName('dashboard.reviews');
		$group->post('/reviews', 'DashboardController:editReviews');
		
		$group->get('/my-listings', 'DashboardController:getMyListings')->setName('dashboard.my-listings');
    
    })->add(new AuthMiddleware);

    $app->group('/api', function(RouteCollectorProxy $group){
        $group->get('/pois', 'ApiController:getAllPois');
		$group->get('/pois/region/{region}', 'ApiController:getPoisByRegion')->setName('api.region');
		$group->get('/user/reviews/{status}', 'ApiController:getReviewByStatus')->setName('api.reviews');
    });

    $app->group('/authentication', function(RouteCollectorProxy $group){
        // Register
        $group->get('/register', 'AuthController:getRegister')->setName('auth.register');
        $group->post('/register', 'AuthController:postRegister');
    })->add(new GuestMiddleware);

    // Login
    $app->post('/authentication/login', 'AuthController:postlogin')->setName('auth.login');
    
    // Logout
    $app->get('/authentication/logout', 'AuthController:logout')->setName('auth.logout');
};