<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class PoiController extends Controller{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

	public function recommendPoi(Request $request, Response $response, $args){
        $post = $request->getParsedBody();
		
		$this->poi->addRecommendation($post["poi-id"]);
		
		return $response;		
    }
    
}