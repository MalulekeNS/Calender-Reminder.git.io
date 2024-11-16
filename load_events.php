<?php
include 'db_connection.php'; // include the connection file

// Fetch all events from the database
$sql = "SELECT id, name, count, date, time FROM events";
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Return the events as a JSON object
echo json_encode($events);

$conn->close();
?>
