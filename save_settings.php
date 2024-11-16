<?php
// Database connection
$host = '192.168.0.100';      // Replace with your database host
$dbname = 'creminde_Reminder'; // Replace with your database name
$username = 'creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Validate and sanitize inputs
$username = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);
$password = password_hash($conn->real_escape_string($data['password']), PASSWORD_BCRYPT); // Hash the password
$theme = $conn->real_escape_string($data['theme']);

// Insert or update settings for the user (assuming one user for now)
$sql = "INSERT INTO users (username, email, password, theme) 
        VALUES ('$username', '$email', '$password', '$theme')
        ON DUPLICATE KEY UPDATE 
        username = '$username', 
        email = '$email', 
        password = '$password', 
        theme = '$theme'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'Settings saved successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
