<?php
header('Content-Type: application/json');

// Database connection details
$host = '192.168.0.100';      // Replace with your database host
$dbname = 'creminde_Reminder'; // Replace with your database name
$username = 'creminde_Reminder';       // Replace with your database username
$password = 'Sevezile@089';           // Replace with your database password

// Create a PDO connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Fetch all events from the 'events' table
try {
    $stmt = $pdo->query('SELECT * FROM events');
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the events as JSON
    echo json_encode(['status' => 'success', 'events' => $events]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch events: ' . $e->getMessage()]);
}
?>
