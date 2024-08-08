<?php
require_once 'connection.php';


// Initialize filter variables
$employeeName = isset($_GET['employee_name']) ? $_GET['employee_name'] : '';
$eventName = isset($_GET['event_name']) ? $_GET['event_name'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Prepare the query with filters
$query = "
    SELECT e.employee_name, ev.event_name, p.event_date, p.participation_fee 
    FROM participations p
    JOIN employees e ON p.employee_id = e.employee_id
    JOIN events ev ON p.event_id = ev.event_id
    WHERE 1=1
";
$params = [];

if ($employeeName) {
    $query .= " AND e.employee_name LIKE :employee_name";
    $params[':employee_name'] = "%$employeeName%";
}

if ($eventName) {
    $query .= " AND ev.event_name LIKE :event_name";
    $params[':event_name'] = "%$eventName%";
}

if ($date) {
    $query .= " AND DATE(p.event_date) = :event_date";
    $params[':event_date'] = $date;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total price
$totalPrice = array_sum(array_column($results, 'participation_fee'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Booking</title>
</head>
<body>
    <h1>Event Booking</h1>
    <form method="GET" action="index.php">
        <label for="employee_name">Employee Name:</label>
        <input type="text" id="employee_name" name="employee_name" value="<?php echo htmlspecialchars($employeeName); ?>">
        
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" value="<?php echo htmlspecialchars($eventName); ?>">
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>">
        
        <button type="submit">Filter</button>
    </form>
    
    <table border="1">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Event Name</th>
                <th>Event Date</th>
                <th>Participation Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($results): ?>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['employee_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['participation_fee']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total Price:</strong></td>
                    <td><strong><?php echo htmlspecialchars($totalPrice); ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="4">No results found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
