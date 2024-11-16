<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $response = [
        'success' => true,
        'username' => $_SESSION['username']
    ];
} else {
    $response = ['success' => false, 'message' => 'User not logged in.'];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
