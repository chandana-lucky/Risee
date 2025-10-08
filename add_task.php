// Best for inserting tasks with user_id, task_name, status
// This version includes parameter safety and proper structure
<?php
header('Content-Type: application/json');

// DB configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "rise";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "DB connection failed: " . $conn->connect_error]));
}

// Accept POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id']) || !isset($data['task_name'])) {
    echo json_encode(["success - add_task.php:22" => false, "message" => "Missing user_id or task_name"]);
    exit;
}

$user_id = intval($data['user_id']);
$task_name = trim($data['task_name']);
$status = 'planned'; // default status

// Insert task
$stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, status) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $task_name, $status);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Task added",
        "task_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Insert failed: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>
