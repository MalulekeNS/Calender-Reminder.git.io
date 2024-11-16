<?php
// Database connection
$host = 'localhost:3306';      // Replace with your database host
$dbname = 'staffhqi_creminde_Reminder'; // Replace with your database name
$username = 'staffhqi_creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password
session_start();

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id=$_SESSION['user_id'];

$sql = "SELECT * FROM events WHERE user_id = ?";
$result = $conn->query($sql);

$events = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);

$conn->close();
?>
