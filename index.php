<?php

require_once 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;
use App\Routes\Router;


// Looking for .env at the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Read view files
$loader = new FilesystemLoader(__DIR__ . '/resources/views');
// Initialize the loader
$twig = new \Twig\Environment($loader);
// Get route path
$uri = $_SERVER['REQUEST_URI'];
//  localhost only 
if ($_ENV['environment'] == 'local') {
    $uri = str_replace('/twigger/', '', $uri);
}

$router = new Router();

$router->get('/', function() {
    echo "home";
});


$router->get('/users', function() {
    echo "users";
});

$router->run();