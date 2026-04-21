<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "student_admin_panel";

    public $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->conn->connect_error) {
            die("DB Connection Failed: " . $this->conn->connect_error);
        }
    }
}