<?php
header('Content-Type: application/json');

include 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['user_id'])) {
        echo json_encode(["success" => false, "message" => "Missing user_id"]);
        exit;
    }

    $user_id = intval($data['user_id']);

    // Step 1: Fetch the latest task with status = 'planned' for the user
    $fetch_stmt = $conn->prepare("SELECT task_name FROM tasks WHERE user_id = ? AND status = 'planned' ORDER BY id DESC LIMIT 1");
    $fetch_stmt->bind_param("i", $user_id);
    $fetch_stmt->execute();
    $fetch_result = $fetch_stmt->get_result();

    if ($fetch_result->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "No planned task found for this user"]);
        exit;
    }

    $row = $fetch_result->fetch_assoc();
    $task_name = $row['task_name'];
    $status = 'pending';

    // Step 2: Insert same task name but with status 'pending'
    $insert_stmt = $conn->prepare("INSERT INTO tasks (user_id, task_name, status) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("iss", $user_id, $task_name, $status);

    if ($insert_stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Task duplicated with status 'pending'",
            "task_id" => $insert_stmt->insert_id,
            "task_name" => $task_name,
            "status" => $status
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Insert failed: " . $insert_stmt->error]);
    }

    $fetch_stmt->close();
    $insert_stmt->close();

} elseif ($method === 'GET') {
    $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

    if ($user_id <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid or missing user_id"]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id, task_name, status, created_at FROM tasks WHERE user_id = ? AND status = 'pending'");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            "id" => $row["id"],
            "task_name" => $row["task_name"],
            "status" => $row["status"],
            "created_at" => $row["created_at"]
        ];
    }

    echo json_encode(["success" => true, "tasks" => $tasks]);
    $stmt->close();

} else {
    echo json_encode(["success" => false, "message" => "Unsupported request method"]);
}

$conn->close();
?>
