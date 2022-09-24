<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;


// Initialize DB
// require_once 'app/config/database.php';


class UserController extends Controller {
    public function index() {

        $users = (new User)->last();

        return $users;

        echo $this->view('app.twig', [
            'title' => 'Test Title',
            'users' => $users
        ]);
    }
}
