<?php

class Database {

    private $servername;
    private $username;
    private $password;
    private $database;
    private $conn;

    function __construct($servername, $username, $password, $database) {
        $this->servername = $servername; 
        $this->username = $username; 
        $this->password = $password; 
        $this->database = $database;
        
    }

    function connect() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->createTable();
        return $this->conn;

        
    }

    function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS event_bookings (
            participation_id INT AUTO_INCREMENT PRIMARY KEY,
            employee_name VARCHAR(100),
            employee_mail VARCHAR(100),
            event_id INT,
            event_name VARCHAR(100),
            participation_fee DECIMAL(10, 2),
            event_date DATETIME,
            version VARCHAR(20)
        )";

        $this->conn->query($sql);
    }
}
?>