<?php
// koneksi/database.php
class Database {
    private $host = "localhost";
    private $db_name = "DB_UAS_PBO_TRPL1B_MuhammadFadhelAqila";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error Koneksi: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>