<?php
namespace App\Controllers;

use App\Controllers\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    public function getRegister(Request $request, Response $response) {
		return $this->view->render($response, 'auth/register.twig');
	}
	
	public function postRegister(Request $request, Response $response, $args){
		$postData = $request->getParsedBody();
		$this->user->create(
			$postData['username'],
			$postData['password']
		);

		$this->container->get('auth')->attempt($postData['username'], $postData['password']);

		$home = $this->urlFor('home', $request);
        return $response->withHeader('Location', $home);
    }
    
    public function postLogin($request, Response $response, $args) {
        $post = $request->getParsedBody();

        $auth = $this->container->get('auth')->attempt($post['username'], $post['password']);

        if(!$auth) {
            $location = $this->urlFor('home', $request);        
        } else{
            $location = $this->urlFor('dashboard', $request); 
        }

        return $response->withHeader('Location', $location);
    }

	public function logout(Request $request, Response $response, $args) {
		unset($_SESSION['username']);
        $home = $this->urlFor('home', $request);
        
        return $response->withHeader('Location', $home);
    }
}