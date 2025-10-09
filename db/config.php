<?php
class DatabaseConnection
{
    private $host = 'localhost';
    private $db_name = 'ecommerce_2025A_aduot_jok';
    private $username = 'aduot.jok';
    private $password = 'Aduot12';
    private $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
