<?php
header('Content-Type: application/json');

// Database credentials
$host = "localhost";
$dbname = "rise";  // Use your actual database name
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}
?>
