<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;


class UserController extends Controller {
    public function index() {

        $users = (new User)->last(2);

        echo $this->view('users/index.twig', [
            'title' => 'Test Title',
            'users' => $users
        ]);
    }
}
