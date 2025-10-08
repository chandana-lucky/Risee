<?php
//http://127.0.0.1:3306/rise/task_handler.php

header('Content-Type: application/json');
include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id']) || !isset($data['task_name'])) {
        echo json_encode(["success" => false, "message" => "Missing user_id or task_name"]);
        exit;
    }

    $user_id = intval($data['user_id']);
    $task_name = trim($data['task_name']);
    $status = isset($data['status']) ? trim($data['status']) : 'planned';

    $stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $task_name, $status);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Task added",
            "task_id" => $stmt->insert_id,
            "status" => $status
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Insert failed: " . $stmt->error]);
    }

    $stmt->close();

} elseif ($method === 'GET') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid or missing user_id"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, task_name, status FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $tasks = [];

    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            "task_id" => $row["id"],
            "task_name" => $row["task_name"],
            "status" => $row["status"]
        ];
    }

    echo json_encode(["success" => true, "tasks" => $tasks]);
    $stmt->close();

} else {
    echo json_encode(["success" => false, "message" => "Unsupported request method"]);
}

$conn->close();
?>
