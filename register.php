<?php
// http://127.0.0.1:3306/rise/register.php

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status - register.php:7" => "error", "message" => "Missing required fields"]);
    exit;
}

$username = $conn->real_escape_string($data['username']);
$email = $conn->real_escape_string($data['email']);
$password = $conn->real_escape_string($data['password']);  // Plain password (consider hashing in future)

// Check if email already exists
$check = $conn->query("SELECT id FROM register WHERE email = '$email'");
if ($check->num_rows > 0) {
    echo json_encode(["status - register.php:18" => "error", "message" => "Email already registered"]);
    exit;
}

// Insert user
$sql = "INSERT INTO register (username, email, password) VALUES ('$username', '$email', '$password')";
if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id;  // ✅ Get the newly inserted user's ID
    echo json_encode([
        "status" => "success",
        "message" => "User registered successfully",
        "user_id" => $user_id      // ✅ Include user_id in the response
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Registration failed: " . $conn->error
    ]);
}
?>
