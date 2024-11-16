<?php
// Database connection
$host = 'localhost:3306';      // Replace with your database host
$dbname = 'staffhqi_creminde_Reminder'; // Replace with your database name
$username = 'staffhqi_creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection faileds: " . $conn->connect_error);
}
?>
