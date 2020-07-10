<?php
namespace App\Controllers;

use App\Controllers\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends Controller{

    public function getReviews(Request $request, Response $response, $args) {
		$admin = $this->container->get('auth')->isAdmin();
		if($admin) {
			$reviewsData = $this->review->getAdminReviews();
		
		}else {
			$reviewsData = $this->review->getPendingReviews($_SESSION['username']);
		}
		
		foreach ($reviewsData as $poi) {
			$poi_collection = $this->poi->getByName($poi->name);
			$imageURL = $poi_collection->image;
			$poi->image = $imageURL;
		}		
		
        return $this->view->render($response, 'dashboard/reviews.twig', [
            'reviews' => $reviewsData
        ]);
    }

	public function getDashboard(Request $request, Response $response, $args) {
		$numListings = $this->dashboard->getCountListings();
		
		$admin = $this->container->get('auth')->isAdmin();
		if($admin) {
			$numReviews = $this->dashboard->getCountAdminReviews();
		}else {
			$numReviews = $this->dashboard->getCountUserReviews();
		}
		

		return $this->view->render($response, 'dashboard/dashboard.twig', [
			'numListings' => $numListings,
			'numReviews' => $numReviews
		]);
    }
    
    public function getListing(Request $request, Response $response, $args) {
        return $this->view->render($response, 'dashboard/add-listing.twig');
	}
	
	public function getMyListings(Request $request, Response $response, $args) {
		$listingData = $this->poi->getByUsername();
		
        return $this->view->render($response, 'dashboard/my-listings.twig', [
			'listings' => $listingData
		]);
	}

    public function editReviews(Request $request, Response $response, $args) {
		$postData = $request->getParsedBody();
		
		if(isset($postData['approve'])) {
			$this->review->aprroveReview($postData['review-id']);
		}else {
			$this->review->cancelReview($postData['review-id']);
		}

        $reviews = $this->urlFor('dashboard.reviews', $request);
        return $response->withHeader('Location', $reviews);
    }

    public function postListing(Request $request, Response $response, $args) {
        $postData = $request->getParsedBody();
        
        $this->poi->addPoi($postData);

		$dashboard = $this->urlFor('dashboard', $request);
		return $response->withHeader('Location', $dashboard);
    }
}
