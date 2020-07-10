<?php
use Dotenv\Dotenv;

$mode = 'development';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

if($mode == 'produdction') {
	$base_path = '/portfolio/poi';
	$url_root = 'https://www.callumilett.co.uk/' . $base_path;

}else {
	$base_path = '/wordpress/demos/points-of-interest';
	$url_root = 'http://localhost' . $base_path;
}


// DB Params
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USERNAME']);
define('DB_PASS', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);

// App Root
define('APP_ROOT', dirname(dirname(__FILE__)));

// Path to Public
define('PUBLIC_PATH', $url_root . '/public');

// Base Path
define('BASE_PATH', $base_path);