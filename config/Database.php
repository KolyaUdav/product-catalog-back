<?php

namespace pcb\config;

use PDO;
use PDOException;

class Database {
    
    private string $host = 'localhost';
    private string $db_name = 'product-catalog';
    private string $username = 'root';
    private string $password = '';

    public function connect(): ?PDO
    {
        $conn = null;

        try {
            $conn = new PDO ('mysql:host='.$this->host.';dbname='.$this->db_name, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection error: '.$e->getMessage();
        }

        return $conn;
    }

}
