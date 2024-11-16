<?php
session_start();

// Check if the user is logged in, if not redirect them to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Include your database connection file
include 'db_connection.php';

// Get the user's information from the database using the session user_id
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .profile-container {
            width: 300px;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 8px;
            box-shadow: 0px 0px 10px red;
            text-align: center;
        }
        .profile-container h2 {
            color: red;
            margin-top: 0;
        }
        .profile-container p {
            color: white;
            margin: 10px 0;
        }
        .logout-btn {
            background-color: red;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Your Profile</h2>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>

        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
