<?php

require_once 'vendor/autoload.php';

use App\Controllers\UserController;
use Twig\Loader\FilesystemLoader;
use Dotenv\Dotenv;
use App\Routes\Router;


// Looking for .env at the root directory
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 *  Initialize [Twig Template]
 */
// Read view files
$loader = new FilesystemLoader(__DIR__ . '/resources/views');
$twig = new \Twig\Environment($loader);

/**
 * Initialize [Route]
 */

$router = new Router();

// Before
// $router->get('/', UserController::class . '::index');
// After
$router->get('/', 'UserController->index');

$router->get('/users', 'UserController->index');

$router->run();
