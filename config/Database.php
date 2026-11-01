<?php
class Database {
    private $host = "127.0.0.1"; // Changed 'localhost' to '127.0.0.1' for reliable connection
    private $db_name = "careerconnect_db";
    private $username = "root";
    private $password = ""; // Removed the space inside quotes. If you have a password, type it here (e.g., "root").
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Added charset=utf8mb4 for proper character encoding
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}