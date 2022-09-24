<?php

namespace App\Models;

class Model {

    // const TABLE = null;
    protected $table = null;

    public function __construct($table) {

        // define('TABLE', get_called_class());

        $this->table = get_called_class();
        // $this->TABLE = get_called_class();
    }


    public static function get() {
        $query = '';
    }
    public static function last() {

        // echo get_called_class();
        try {
            // $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id DESC LIMIT 1';
            // echo $query;
        } catch (\Exception $e) {
            echo $e;
        }
    }
    private function exec() {
    }
}
