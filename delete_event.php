<?php
include 'db_connection.php'; // include the connection file

// Check if an ID is provided in the GET request
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // SQL query to delete the event by its ID
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
