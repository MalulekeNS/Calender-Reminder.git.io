<?php
include 'db_connection.php'; // include the connection file

// Check if the request is POST and contains valid data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Retrieve posted data
    $eventName = $input['name'];
    $eventCount = $input['count'];
    $eventDate = $input['date'];
    $eventTime = $input['time'];

    // SQL query to insert event into the database
    $sql = "INSERT INTO events (name, count, date, time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siss", $eventName, $eventCount, $eventDate, $eventTime);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
