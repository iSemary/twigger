<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller {

    public function index() {
        $values = (new Category)->last(10);
        echo $this->view('categories/index.twig', [
            'title' => 'categories',
            'categories' => $values
        ]);
    }

    public function show() {

    }

    public function create() {

    }

    public function save() {

    }

    public function edit() {

    }

    public function update() {

    }

    public function explode() {

    }


}