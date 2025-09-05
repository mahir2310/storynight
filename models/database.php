<?php

class Database{

    private $host = "localhost";
    private $db   = "storynight";
    private $user = "root";
    private $pass = "";
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $_SESSION["db_error"] = $e;
            die("Database connection failed: " . $e->getMessage());
        }

    }
    public function getConnection() {
        return $this->pdo;
    }

}

?>