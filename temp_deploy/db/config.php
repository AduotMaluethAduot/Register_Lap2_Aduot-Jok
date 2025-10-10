<?php
/**
 * Database Configuration
 * This file loads environment configuration and provides database connection
 */

// Load environment configuration
require_once __DIR__ . '/config.env.php';

class DatabaseConnection
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $conn;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->charset = DB_CHARSET;
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
            // Log error instead of displaying it
            error_log("Database connection error: " . $exception->getMessage());
            
            // Show user-friendly message
            if (APP_ENV === 'development') {
                echo "Database connection error: " . $exception->getMessage();
            } else {
                echo "Database connection failed. Please try again later.";
            }
        }

        return $this->conn;
    }
}
?>
