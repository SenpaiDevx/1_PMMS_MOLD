<?php
class Connection
{
    private $host = "localhost";
    private $port = 8080; // use if other 3rd party software use '80'
    private $db_name = "1_pmms";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // $this->conn = new PDO("mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->db_name,$this->username,$this->password.";");
            $this->conn->exec('SET NAMES utf8mb4'); // SET THIS FOR special character
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }

    public function connect_port()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";port=".$this->port.";dbname=".$this->db_name,$this->username,$this->password.";");
            $this->conn->exec('SET NAMES utf8mb4'); // SET THIS FOR special character
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
