<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the posted form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and bind the SQL statement to insert the user into the database
    if ($stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)")) {
        $stmt->bind_param("ss", $username, $hashed_password);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "Registration successful!";
            header('Location: login.html');
            exit();
        } else {
            // SQL error during statement execution
            echo "Error during statement execution: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // SQL error during statement preparation
        echo "Error during statement preparation: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
