<?php

namespace App\Controllers;

use App\Controllers\Controller;

class UserController extends Controller {
    public function index() {

        echo $this->view('app.twig', [
            'title' => 'Test Title'
        ]);
    }
}
