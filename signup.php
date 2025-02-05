<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");


// Include database connection file
include "connection.php";

// Read the raw POST data
$input = file_get_contents('php://input');

// Decode JSON data
$data = json_decode($input, true);
$logData = $data;
unset($logData['password']); // Remove password from log data
error_log("Decoded data: " . print_r($logData, true), 3, "debug.log"); // Log the decoded data without password

// Fallback to $_POST if JSON decoding fails
if (!$data) {
    $data = $_POST;
    error_log("Fallback to \$_POST: ", 3, "debug.log"); // Log fallback data
}

// Create a new array to store valid data
$validData = [];

$validData['username'] = isset($data['username']) ? $data['username'] : '';
$validData['email'] = isset($data['email']) ? $data['email'] : '';
$validData['password'] = isset($data['password']) ? $data['password'] : '';

// Remove password from validData for logging purposes
$validDataForLogging = $validData;
unset($validDataForLogging['password']); // Remove password from log data

// Log the validData array, excluding password
error_log("Valid data (excluding password): " . print_r($validDataForLogging, true), 3, "debug.log");

// Handle empty input
if (empty($validData['username']) || empty($validData['email']) || empty($validData['password'])) {
    error_log("Missing required fields.", 3, "debug.log");
    http_response_code(400);
    echo json_encode(['message' => 'Missing required fields.']);
    exit();
}

// Sanitize inputs
$username = $validData['username'];
$email = $validData['email'];
$password = $validData['password']; // Will hash it later

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid email address.']);
    exit();
}

// Hash the password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Check if the username already exists
$stmt = $con->prepare("SELECT user_id FROM users WHERE username = ?");
$stmt->bind_param("s", $username); // "s" means the parameter is a string
$stmt->execute();
$stmt->store_result();

// Check if the username is already registered
if ($stmt->num_rows > 0) {
    http_response_code(409);  // Conflict
    echo json_encode(['message' => 'Username already taken.']);
    $stmt->close();
    exit();
}

// Prepare the query to check if the email already exists
$stmt = $con->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email); // "s" means the parameter is a string
$stmt->execute();
$stmt->store_result();

// Check if the email is already registered
if ($stmt->num_rows > 0) {
    http_response_code(409);
    echo json_encode(['message' => 'Email already registered.']);
    $stmt->close();
    exit();
}

// Prepare the insert statement
$stmt = $con->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password_hash); // "sss" means all parameters are strings

// Execute the query
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['message' => 'Sign-up successful!']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Failed to sign up. Please try again.']);
}

// Close the statement
$stmt->close();
?>
