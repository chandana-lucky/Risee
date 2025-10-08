
<?php
 // http://127.0.0.1:3306/rise/login.php

include 'config.php';
$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['username']) || empty($data['password'])) {
    echo json_encode(["status - login.php:6" => "error", "message" => "Username and password required"]);
    exit;
}

$username = $conn->real_escape_string($data['username']);
$password = $conn->real_escape_string($data['password']);

$sql = "SELECT * FROM register WHERE username = '$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if ($password === $user['password']) {
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "user_id" => $user['id'],
            "username" => $user['username']
        ]);
    } else {
        echo json_encode(["status - login.php:27" => "error", "message" => "Incorrect password"]);
    }
} else {
    echo json_encode(["status - login.php:30" => "error", "message" => "Username not found"]);
}
?>
