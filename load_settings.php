<?php
// Database connection
$host = 'localhost:3306';      // Replace with your database host
$dbname = 'staffhqi_creminde_Reminder'; // Replace with your database name
$username = 'staffhqi_creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming there's only one user for now
$sql = "SELECT username, email, theme FROM users LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in JSON format
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'settings' => $row]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No settings found']);
}

$conn->close();
?>
