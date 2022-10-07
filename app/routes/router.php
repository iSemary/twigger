<?php

namespace App\Routes;


use App\Core\Init\DB;
use App\core\initializer\LazyMVC;

class router {

    private array $handlers;
    private const CONTROLLER_PATH = '\App\Controllers\\';
    private const ABSOLUTE_CONTROLLER_PATH = '/app/controllers/';
    private const MODEL_PATH = '\App\Models\\';
    private const ABSOLUTE_MODEL_PATH = '/app/models/';
    private const ABSOLUTE_VIEW_PATH = '/resources/views/';
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';
    private const METHOD_PATCH = 'PATCH';


    /**
     * Auto generate the methods needs
     *
     * @param string $method
     * @param string $path
     * @param [type] $handler
     * @return void
     */
    private function initHandler(string $method, string $path, $handler): void {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler,
        ];
    }

    public function get(string $path, $handler): void {
        $this->initHandler(self::METHOD_GET, $path, $handler);
    }

    public function post(string $path, $handler): void {
        $this->initHandler(self::METHOD_POST, $path, $handler);
    }

    // Collection [Like resources in laravel]
    public function collection(string $path, $handler): void {
        $CollectionHandlers = ['index', 'create', 'save', 'edit', 'update', 'explode'];
        $CollectionMethods = [self::METHOD_GET, self::METHOD_GET, self::METHOD_POST, self::METHOD_GET, self::METHOD_PATCH, self::METHOD_POST];
        foreach ($CollectionHandlers as $index => $CollectionHandler) {
            $this->initHandler($CollectionMethods[$index], $path . '/' . $CollectionHandler, $handler . '->' . $CollectionHandler);
        }
    }


    /*
     * ========= THE LAZY SCRIPT
     * Create controller, model and views based on $path name and db table structure
     * Views -> Twig // Defaults
     * */
    public function lazy(string $path) {
        $LazyModel = ucfirst($path);
        $LazyHandler = $LazyModel . 'Controller';
        // Check if controller not exists
        // Then Generate a controller
        $LazyHandlerFile = getcwd() . self::ABSOLUTE_CONTROLLER_PATH . $LazyHandler . '.php';
        if (!file_exists($LazyHandlerFile)) {
            // Get database columns by model name
            $db_name = $_ENV['db_name'];
            $db_table = DB::guess_table_name($path);
            $db_columns = (new DB)->table_columns($db_name, $db_table);
            // Generate model
            $LazyModelFile = getcwd() . self::ABSOLUTE_MODEL_PATH . $LazyModel . '.php';
//            LazyMVC::model($LazyModel, $db_table, $LazyModelFile, $db_columns);
            // Generate controller
//            LazyMVC::controller($LazyModel, $db_table, $LazyHandler, $LazyHandlerFile, $db_columns);
            // Generate views
            LazyMVC::views($LazyModel, $db_table, getcwd() . self::ABSOLUTE_VIEW_PATH . $db_table . '/', $db_columns);

            die ('');
        }

        $this->collection($path, $LazyHandler);
    }

    public function run() {
        $RequestURI = parse_url($_SERVER['REQUEST_URI']);
        $RequestPath = $RequestURI['path'];
        $RequestMethod = $_SERVER['REQUEST_METHOD'];

        $callback = null;
        foreach ($this->handlers as $handler) {
            // making sure that paths equals and the methods equals [Maybe same path but not same method]
            if ($handler['path'] === $RequestPath && $RequestMethod === $handler['method']) {
                $callback = $handler['handler'];
            }
        }

        // check if callback still null and redirect to 404
        if (!$callback) {
            // TODO make a custom 404 page
            echo "404 Not found " . $handler['handler'] . " Not exists";
            return false;
        } else {
            // EX UserController->index
            $slices = explode('->', $callback);
            // UserController
            $class = array_shift($slices);
            // index
            $method = array_shift($slices);
            // new App\Controllers\UserController
            $class = self::CONTROLLER_PATH . $class;
            $handler = new $class;
            // Check if not method exists
            if (!method_exists($handler, $method)) {
                die("Method " . $method . " not exists in " . $class);
            }
            // returns App\Controllers\UserController::class::index
            $callback = [$handler, $method];
        }


        // execute the route and redirect to it's handler
        call_user_func_array(
            $callback,
            [
                array_merge($_GET, $_POST)
            ]
        );
    }
}
