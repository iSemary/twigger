<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;


class UserController extends Controller {
    public function index() {

        echo User::last();

        echo $this->view('app.twig', [
            'title' => 'Test Title'
        ]);
    }
}
