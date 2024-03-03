<?php

// Database Class
class Database {
    // Database Properties
    private $host = 'localhost:3307';
    private $db_name = 'test';
    private $username = 'root';
    private $password = '';
    private $connection = null;

    // Function for making connection with database
    public function connect() {
        try {
            // connecting to database
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username,
                $this->password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $this->connection;
    }
}
