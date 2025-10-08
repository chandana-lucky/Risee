<?php
header('Content-Type: application/json');

include 'config.php';

// Handle GET request (Fetch tasks)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id <= 0) {
        echo json_encode(["success - test_tasks_db.php:21" => false, "message" => "Invalid or missing user_id"]);
        exit;
    }

    $query = "SELECT id, task_name, status, created_at FROM tasks WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $tasks = [];

    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }

    echo json_encode(["success - test_tasks_db.php:37" => true, "tasks" => $tasks]);
    $stmt->close();
}

// Handle POST request (Add task)
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id']) || !isset($data['task_name'])) {
        echo json_encode(["success - test_tasks_db.php:46" => false, "message" => "Missing user_id or task_name"]);
        exit;
    }

    $user_id = intval($data['user_id']);
    $task_name = trim($data['task_name']);
    $status = isset($data['status']) ? trim($data['status']) : 'planned';

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $task_name, $status);

    if ($stmt->execute()) {
        echo json_encode(["success - test_tasks_db.php:58" => true, "message" => "Task added", "task_id" => $stmt->insert_id]);
    } else {
        echo json_encode(["success - test_tasks_db.php:60" => false, "message" => "Insert failed: " . $stmt->error]);
    }

    $stmt->close();
}

// Unsupported method
else {
    echo json_encode(["success - test_tasks_db.php:68" => false, "message" => "Unsupported request method"]);
}

$conn->close();
?>
