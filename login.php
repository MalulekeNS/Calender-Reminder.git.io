<?php
// Start the session
session_start();

include 'db_connection.php';

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Turn off output buffering to avoid extra whitespace or warnings
    ob_start();
    
    // Retrieve the posted form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    
    if ($stmt === false) {
        $response = [
            'success' => false,
            'message' => 'Error in preparing the SQL query.'
        ];
        // Output the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with that username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $db_username, $hashed_password);
        $stmt->fetch();

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Start the user session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username;

            // Success response for login with username included
            $response = [
                'success' => true,
                'message' => 'Login successful.',
                'username' => $db_username // Include the username in the response
            ];
        } else {
            // Invalid password
            $response = [
                'success' => false,
                'message' => 'Invalid password. Please try again.'
            ];
        }
    } else {
        // No user with that username
        $response = [
            'success' => false,
            'message' => 'No account found with that username.'
        ];
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();

    // Clear output buffer to prevent any non-JSON data from being sent
    ob_end_clean();

    // Output the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
