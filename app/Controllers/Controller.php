<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;



class Controller {

    protected $container;
    protected $view;
    protected $review;
    protected $poi;
    protected $user;
    protected $dashboard;

    public function __construct($container) {
        $this->container = $container;

        $this->view      = $this->container->get('view');
        $this->review    = $this->container->get('ReviewModel');
        $this->poi       = $this->container->get('PoiModel');
        $this->user      = $this->container->get('UserModel');
        $this->dashboard = $this->container->get('DashboardModel');
    }

    public function urlFor(String $url, Request $request){
        return RouteContext::fromRequest($request)->getRouteParser()->urlFor($url);
	}
	
	public function getPoiImage($poi){
		$GooglePlacesApi = $this->container->get('GooglePlacesAPI');
		$placeSearch = $GooglePlacesApi->placeSearch($poi);
		$candidates = $placeSearch->candidates[0];
		
		if(property_exists($candidates, "photos")) {
			$ref = $placeSearch->candidates[0]->photos[0]->photo_reference;
			$imageURL = $GooglePlacesApi->imageByReference($ref);
			return $imageURL;
		}
	
	}

	public function getPoiRating($poi){
		$GooglePlacesApi = $this->container->get('GooglePlacesAPI');
		$placeSearch = $GooglePlacesApi->placeSearch($poi);
		$candidates = $placeSearch->candidates[0];

		if(property_exists($candidates, "rating")){
            return $candidates->rating;
        }
	}
}
