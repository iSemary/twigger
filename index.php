<?php

require_once 'vendor/autoload.php';
use Dotenv\Dotenv;
use App\Routes\Router;
// Looking for .env at the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
// Initialize DB
require_once 'app/config/database.php';


/**
 * Initialize [Routes]
 */
$router = new Router();
$router->get('/', 'UserController->index');
$router->get('/users', 'UserController->index');
$router->run();
