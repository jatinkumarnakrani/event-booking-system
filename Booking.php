<?php

class Booking {
    private $conn;
    private $tablename = 'event_bookings';
    private $filters = array();

    function __construct($conn) {
        $this->conn = $conn;
    }

    function setFilters($employee_name = null, $event_name = null, $event_date= null) {

        if ($employee_name) {
            $this->filters[] = "employee_name LIKE '%" . $employee_name . "%'";
        }
        
        if ($event_name) {
            $this->filters[] = "event_name LIKE '%" . $event_name . "%'";
        }

        if ($event_date) {
            $this->filters[] = "event_date = '" . date('Y-m-d H:i:s', strtotime($event_date)) . "'";
        }
    }

    function getBookings() {

        $sql = "SELECT * FROM $this->tablename";

        if (!empty($this->filters)) {
            $whereClause = " WHERE " . implode(" AND ", $this->filters);
            $sql .= $whereClause;
        }

        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {            
            return $result;
        } else {
            return false;
        }
    }

    function getTotalPrice() {
        $sql = "SELECT SUM(participation_fee) as total_price  FROM $this->tablename";
        
        if (!empty($this->filters)) {
            $whereClause = " WHERE " . implode(" AND ", $this->filters);
            $sql .= $whereClause;
        }

        $result = $this->conn->query($sql);
        if ($result) {            
            $row = $result->fetch_assoc();
            return $row['total_price'];
        } else {
            return false;
        }
    }
}

?>
