<?php
require_once "Database.php";
require_once "Booking.php";

$servername = "localhost";
$username = "root";
$password = "";
$database =  "test";

try {
    $employee_name = isset($_POST['employee_name']) ? $_POST['employee_name'] : null;
    $event_name = isset($_POST['event_name']) ? $_POST['event_name'] : null;
    $event_date = isset($_POST['event_date']) ? $_POST['event_date'] : null;
    
    $database = new Database($servername,$username,$password,$database);
    $booking = new Booking($database->connect());
    $booking->setFilters($employee_name, $event_name, $event_date);
    $bookings = $booking->getBookings();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Booking System</title>
    </head>
    <body>    
        <?php if($bookings): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <label for="employeeName">Employee Name:</label>
                <input type="text" id="employeeName" name="employee_name" value="<?php echo $employee_name; ?>">

                <label for="eventName">Event Name:</label>
                <input type="text" id="eventName" name="event_name" value="<?php echo $event_name; ?>">

                <label for="eventDate">Event Date:</label>
                <input type="date" id="eventDate" name="event_date" value="<?php echo $event_date; ?>">

                <button type="submit">Filter</button>
            </form>
            <br><br><br>
            <table border="1">
                <thead>
                    <th>Employee Name</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Participation Fee</th>
                </thead>
                <tbody>
                    <?php while ($row = $bookings->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['employee_name'] ?></td>
                            <td><?php echo $row['event_name'] ?></td>
                            <td><?php echo $row['event_date'] ?></td>
                            <td><?php echo $row['participation_fee']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3">Total Price</td>
                        <td><?php echo $booking->getTotalPrice(); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            Data is not found, simply <a href="import_data.php">Click Here</a> to trigger automatic data import from JSON.
        <?php endif; ?>
    </body>
</html>