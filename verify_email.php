<?php
//http://127.0.0.1:3306/rise/verify_email.php

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Email required"
    ]);
    exit;
}

$email = $conn->real_escape_string($data['email']);

$sql = "SELECT * FROM register WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    echo json_encode([
        "status" => "success",
        "message" => "Email verified"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Email not found"
    ]);
}
?>
