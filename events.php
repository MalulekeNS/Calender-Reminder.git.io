<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
// Database connection
include 'db_connection.php';


try {
     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Log the error message (or print it temporarily for debugging)
    error_log($e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != null) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = 0;
}

switch ($method) {
    case 'GET':
            $stmt = $pdo->prepare('SELECT * FROM events WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($events);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare('INSERT INTO events (name, date, count,user_id) VALUES (:name, :date, :count, :user_id)');
        $stmt->execute([
            'name' => $input['name'],
            'date' => $input['date'],
            'count' => $input['count'],
            'user_id' => $user_id
        ]);
        echo json_encode(['status' => 'success', 'data' => $input]);
        break;

    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $pdo->prepare('DELETE FROM events WHERE date = :date');
        $stmt->execute(['date' => $input['date']]);
        echo json_encode(['status' => 'success']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        break;
}
?>
