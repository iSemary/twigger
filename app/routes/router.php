<?php

namespace App\Routes;


class router {

    private array $handlers;
    private const CONTROLLER_PATH = '\App\Controllers\\';
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';


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
            echo "404 Not found";
            return false;
        } else {
            // EX UserController->index
            $slices = explode('->',$callback);
            // UserController
            $class = array_shift($slices);
            // index
            $method = array_shift($slices);
            // new App\Controllers\UserController
            $class = self::CONTROLLER_PATH . $class;
            $handler = new $class;
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


