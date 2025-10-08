<?php
//http://127.0.0.1:3306/rise/reset_password.php

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

// Check for required fields
if (!isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["status - reset_password.php:8" => "error", "message" => "Missing email or password"]);
    exit;
}

$email = $conn->real_escape_string($data['email']);
$newPassword = $conn->real_escape_string($data['password']); // plain text

// Update password
$sql = "UPDATE register SET password = '$newPassword' WHERE email = '$email'";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status - reset_password.php:18" => "success", "message" => "Password reset successfully"]);
} else {
    echo json_encode(["status - reset_password.php:20" => "error", "message" => "Failed to reset password"]);
}
?>
