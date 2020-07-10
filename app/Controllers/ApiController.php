<?php

namespace App\Controllers;

use App\Controllers\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiController extends Controller{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
	}
	
	public function getReviewByStatus(Request $request, Response $response, $args){

		switch ($args['status']) {
			case 'approved':
				$reviewsData = $this->review->getApprovedReviews($_SESSION['username']);
				break;

			case 'pending':
				$reviewsData = $this->review->getPendingReviews($_SESSION['username']);
				break;

			case 'canceled':
				$reviewsData = $this->review->getCanceledReviews($_SESSION['username']);
				break;

			default:
				$reviewsData = $this->review->getAllReviews($_SESSION['username']);
				break;
		}

		foreach ($reviewsData as $poi) {
			$poi_collection = $this->poi->getByName($poi->name);
			$imageURL = $poi_collection->image;
			$poi->image = $imageURL;
		}	

		$response->getbody()->write(json_encode($reviewsData));
		return $response;
	}


    public function getAllPois(Request $request, Response $response, $args) {
        $pois = $this->poi->getAll();
        $response->getbody()->write(json_encode($pois));
        return $response;
    }

    public function getPoisByRegion(Request $request, Response $response, $args) {
        $pois = $this->poi->getByRegion($args['region']);

        if(!$pois) {
            $response->getbody()->write('No results found');
            header("Content-Type: text/plain");
			return $response->withStatus(404); 
			
        }else {
			header("Content-Type: application/json");
			
            $response->getbody()->write(json_encode($pois));
            return $response;
        }
    }
}