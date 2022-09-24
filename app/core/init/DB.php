<?php

namespace App\Core\Init;

use PDO;
use PDOException;

class DB {

    private $db;

    public function __construct() {
        $DatabaseName = $_ENV['db_name'];
        $DatabaseHost = 'localhost';

        $dsn = 'mysql:host=' . $DatabaseHost . ';dbname=' . $DatabaseName;
        $user = $_ENV['db_user'];
        $pass = $_ENV['db_pass'];

        $settings = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        );

        try {
            $this->db = new PDO($dsn, $user, $pass, $settings);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Failed To Connect' . $e->getMessage();
            die();
        }
    }

    public function run($query) {
        $Run = $this->db;
        $Checkuser = $Run->prepare($query);
        $Checkuser->execute();
        $Checkuserf = $Checkuser->fetchAll();

        var_dump($Checkuserf);

        // $this->db->prepare($query);
        // $this->db->execute();
        // $this->db = $this->db->fetch();

        // echo $this->db;
    }
}
