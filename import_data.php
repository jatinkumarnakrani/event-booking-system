<?php
require_once "Database.php";

$servername = "localhost";
$username = "root";
$password = "";
$database =  "test";
$tblname = "event_bookings";
$jsonFilePath = "Data/Events.json";
$chunkSize = 5;

try {
    if (!file_exists($jsonFilePath)) {
        throw new Exception("JSON file not found.");
    }

    $database = new Database($servername,$username,$password,$database);
    $conn = $database->connect();

    $jsonData = file_get_contents($jsonFilePath);
    $data = json_decode($jsonData, true);
    if($jsonData) {
        $dbFieldDefaultValues = array(
            "participation_id" => "",
            "employee_name" => "",
            "employee_mail" => "",
            "event_id" => "",
            "event_name" => "",
            "participation_fee" => "",
            "event_date"=> "",
            "version"=> ""
        );

        $sqlStart = "INSERT INTO $tblname (" . implode(",",array_keys($dbFieldDefaultValues)) . ") VALUES ";
        $sqlEnd = "ON DUPLICATE KEY UPDATE ". implode(', ', array_map(function ($field) {
            return "$field = VALUES($field)";
        }, array_keys($dbFieldDefaultValues)));

        $chunks = array_chunk($data, $chunkSize);
        foreach ($chunks as $chunk) {
            $records = array();
            foreach ($chunk as $record) {
                $record = array_merge($dbFieldDefaultValues, $record);
                $records[] = "('". implode("','",$record) . "')";
            }
            $newSQL = $sqlStart . implode(",",$records) . $sqlEnd;
            $conn->query($newSQL);
        }
    }
    echo "Data imported successfully. Please <a href='index.php'>Click Here</a> to redirect to the home page.";


} catch (Exception $e) {
    echo "Error: ". $e->getMessage();
}
?>
