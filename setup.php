<?php
require_once 'connection.php';

// Table Creation if not Exists
try {
    $employeesTbl = "
    CREATE TABLE IF NOT EXISTS employees (
        employee_id INT AUTO_INCREMENT PRIMARY KEY,
        employee_name VARCHAR(255) NOT NULL,
        employee_mail VARCHAR(255) UNIQUE NOT NULL
    );";
    $pdo->exec($employeesTbl);
    echo nl2br("Table employees created successfully. \n");
    
    $eventsTbl = "
    CREATE TABLE IF NOT EXISTS events (
        event_id INT AUTO_INCREMENT PRIMARY KEY,
        event_name VARCHAR(255) NOT NULL
    );";
    $pdo->exec($eventsTbl);
    echo nl2br("Table events created successfully \n");

    $participationsTbl = "
    CREATE TABLE IF NOT EXISTS participations (
        participation_id INT AUTO_INCREMENT PRIMARY KEY,
        employee_id INT,
        event_id INT,
        participation_fee DECIMAL(10, 2),
        version VARCHAR(255),
        event_date DATETIME,
        FOREIGN KEY (employee_id) REFERENCES employees(employee_id),
        FOREIGN KEY (event_id) REFERENCES events(event_id)
    );";
    $pdo->exec($participationsTbl);
    echo nl2br("Table participations created successfully \n");
} catch (PDOException $e) {
    echo nl2br("Error creating tables: " . $e->getMessage());
}    

try {
    echo nl2br("Inserting data from JSON...\n");

    // // Read JSON file
    $jsonData = file_get_contents('Code Challenge (Events).json');
    $data = json_decode($jsonData, true);


    foreach ($data as $eventBooking) {
        // Prepare data
        $participationId = $eventBooking['participation_id'];
        $employeeName = $eventBooking['employee_name'];
        $employeeMail = $eventBooking['employee_mail'];
        $eventId = $eventBooking['event_id'];
        $eventName = $eventBooking['event_name'];
        $participationFee = $eventBooking['participation_fee'];
        $eventDate = $eventBooking['event_date'];
        $version = isset($eventBooking['version']) ? $eventBooking['version'] : null;

        //check employeee and insert
        $checkEmp = "SELECT employee_id FROM employees WHERE employee_mail = :employee_mail AND employee_name = :employee_name";
        $stmt = $pdo->prepare($checkEmp);
        $stmt->bindParam(':employee_mail', $employeeMail);
        $stmt->bindParam(':employee_name', $employeeName);
        $stmt->execute();
        $employeeId = $stmt->fetchColumn();
        if(!$employeeId) {
            $insertEmp = "INSERT INTO employees (employee_mail, employee_name) VALUES (:employee_mail, :employee_name)";
            $stmt = $pdo->prepare($insertEmp);
            $stmt->bindParam(':employee_mail', $employeeMail);
            $stmt->bindParam(':employee_name', $employeeName);
            $stmt->execute();
            $employeeId = $pdo->lastInsertId();
        }

        // check event and insert
        $checkEvent = "SELECT event_id FROM events WHERE event_id = :event_id";
        $stmt = $pdo->prepare($checkEvent);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        $eventId = $stmt->fetchColumn();
        if(!$eventId) {
            $insertEvent = "INSERT INTO events (event_name) VALUES (:event_name)";
            $stmt = $pdo->prepare($insertEvent);
            $stmt->bindParam(':event_name', $event_name);
            $stmt->execute();
            $eventId = $pdo->lastInsertId();
        }


        // check participation and insert
        $checkParticipation = "SELECT participation_id FROM participations WHERE participation_id = :participation_id";
        $stmt = $pdo->prepare($checkParticipation);
        $stmt->bindParam(':participation_id', $participationId);
        $stmt->execute();
        $participationId = $stmt->fetchColumn();
        if(!$participationId) {
            $insertEmp = "INSERT INTO participations (employee_id, event_id, participation_fee, event_date, version) VALUES (:employee_id, :event_id, :participation_fee, :event_date, :version)";
            $stmt = $pdo->prepare($insertEmp);
            $stmt->bindParam(':employee_id', $employeeId);
            $stmt->bindParam(':event_id', $eventId);
            $stmt->bindParam(':participation_fee', $participationFee);
            $stmt->bindParam(':event_date', $eventDate);
            $stmt->bindParam(':version', $version);
            $stmt->execute();
            $eventId = $pdo->lastInsertId();
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "Data imported successfully!\n";
?>
