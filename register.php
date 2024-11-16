<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connection.php';

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // Respond with a JSON error message
    $response = [
        'success' => false,
        'message' => "Database connection failed: " . $conn->connect_error
    ];
    echo json_encode($response);
    exit();
}

// Check if the request method is POST (the form has been submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and bind the SQL statement to insert the user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    // Check if the statement was prepared successfully
    if ($stmt === false) {
        $response = [
            'success' => false,
            'message' => "Failed to prepare the SQL statement: " . $conn->error
        ];
        echo json_encode($response);
        exit();
    }

    // Bind parameters and execute the query
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        // Respond with a success message
        $response = [
            'success' => true,
            'message' => "Registration successful!"
        ];
    } else {
        // Respond with an error message if the execution failed
        $response = [
            'success' => false,
            'message' => "Error: " . $stmt->error
        ];
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
