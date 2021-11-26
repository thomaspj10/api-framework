<?php

class Database {

    private $conn;

    function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "mysql";

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=database", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $response = new Response("Internal server error", 500);
            $response->display();
        }
    }

    function prepare($sql) {
        return $this->conn->prepare($sql);
    }

}

?>