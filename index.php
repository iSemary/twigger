<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use App\Routes\Router;
// Looking for .env at the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * Initialize [Routes]
 **/
$router = new Router();
$router->get('/', 'UserController->index');
$router->get('/users', 'UserController->index');
$router->collection('/test', 'TestController');

$router->lazy('category');

$router->run();
