<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends Controller{

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);
    }

    public function home(Request $request, Response $response) {
        return $this->view->render($response, 'home/home.twig');
	}    
}