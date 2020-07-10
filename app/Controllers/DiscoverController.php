<?php
namespace App\Controllers;

use App\Controllers\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DiscoverController extends Controller{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    public function postReview(Request $request, Response $response, $args) {

		if(!isset($_SESSION['username'])) {
            echo 'Authentication Required';
			
        }else {
			 $post = $request->getParsedBody();
			
			$params = [
				$post['poi_id'],
				$post['poi_name'],
				$post['review_text'],
				$post['status'],
				$_SESSION['username']
			];

			$this->review->create($params);	
		}

        return $response;
    }

    public function discoverName(Request $request, Response $response, $args) {
        $poiData = $this->poi->getbyName($args['poi']);
		$reviewsData = $this->review->getReviewsByID($poiData->ID);
		
        return $this->view->render($response, 'discover/discover-detail.twig', [
            'poi' => $poiData,
            'reviews' => $reviewsData
        ]);
        
    }
    
    public function getregion(Request $request, Response $response, $args) {   
		$pois = $this->poi->getByRegion($args['region']);

		if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
			if(!$pois) {
				echo "<h1>No Search Results Found!";
				return $response;
			}else {
				return $this->view->render($response, 'discover/search-results.twig', [
					'region' => $args['region'],
					'pois' => $pois
        		]);
			}

		}else {
			if(!$pois) {
				return $this->view->render($response->withStatus(404), 'error404.twig');
			
			}else {
				return $this->view->render($response, 'discover/discover.twig', [
					'region' => $args['region'],
					'pois' => $pois
        		]);
			}
			
		}

    }
    
    public function getCategory(Request $request, Response $response, $args) {        
        $pois = $this->poi->getByCategory($args['category']);

		return $this->view->render($response, 'discover/discover.twig', [
			'category' => $args['category'],
			'pois' => $pois
		]);
	}
}