<?php
require './connection.php';
header('Content-Type: application/json');
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Check if username or password is empty
if (empty($username) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit();
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    // Verify the hashed password
    if (password_verify($password, $row['password'])) {
        // Password is correct
        session_regenerate_id(true); // Regenerate session ID
        
        // Set session variables (these won't be used in Flutter, but it's useful for PHP-based sessions)
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        
        // Return success response with HTTP status code 200
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // Incorrect password
        http_response_code(401); // Unauthorized
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    }
} else {
    // Username not found
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Invalid username']);
}

$stmt->close();
$con->close();
?>
