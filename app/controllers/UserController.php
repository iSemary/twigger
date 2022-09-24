<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;


// Initialize DB
// require_once 'app/config/database.php';


class UserController extends Controller {
    public function index() {

        $users = (new User)->last(2);

        echo $this->view('users/index.twig', [
            'title' => 'Test Title',
            'users' => $users
        ]);
    }
}
