<?php

namespace App\Routes;


class router {

    private array $handlers;
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';


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
        var_dump($RequestPath); 
    }
}


// echo $twig->render('app.twig', array('route' => $uri));
