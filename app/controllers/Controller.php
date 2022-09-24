<?php

namespace App\Controllers;
use Twig\Loader\FilesystemLoader;


class Controller {

    // Dynamic Twig Template Rendering
    public function view(string $file, array $vars) {

        $loader = new FilesystemLoader(__DIR__ . '/../../resources/views');
        $twig = new \Twig\Environment($loader);
        
        echo $twig->render($file, $vars);
    }
}
