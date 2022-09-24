<?php

namespace App\Models;

use App\Core\Init\DB;

abstract class Model {
    protected $table;

    public function TableName() {
        // Check if there's a table property OR create a dynamic table name depended on the class name
        // Ex: User -> users
        $BaseClass = explode('\\', get_called_class());
        $BaseClass = $BaseClass[array_key_last($BaseClass)]; // users
        // TODO make sure to add _ if class has 2 Capitalize words

        return $this->table ?? strtolower($BaseClass . 's');
    }

    public function get() {
        $query = '';
    }
    public function last($limit = 1) {
        try {
            $query = 'SELECT * FROM ' . $this->TableName() . ' ORDER BY id DESC LIMIT ' . $limit;
            return $this->exec($query);
        } catch (\Exception $e) {
            echo $e;
        }
    }
    public function exec($query) {
        return (new DB)->run($query);
    }
}
