<?php
session_start();
// Set response to be JSON
header('Content-Type: application/json');

// Database connection details
$host = 'localhost:3306';      // Replace with your database host
$dbname = 'staffhqi_creminde_Reminder'; // Replace with your database name
$username = 'staffhqi_creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password
$user_id=$_SESSION['user_id'];
// Connect to the database using PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Process the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and decode JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate input fields
    if (isset($input['name'], $input['count'], $input['date'])) {
        // Insert event into the database
        $sql = 'INSERT INTO events (name, date, count,user_id) VALUES (:name, :date, :count, :user_id)';
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':name'  => $input['name'],
                ':count' => $input['count'],
                ':date'  => $input['date'],
                'user_id' => $user_id
            ]);

            // Return success response
            echo json_encode(['status' => 'success', 'message' => 'Event added successfully']);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add event: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields: name, count, or date']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
