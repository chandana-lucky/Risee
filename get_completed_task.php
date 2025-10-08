<?php
// http://127.0.0.1/rise/get_completed_task.php
header('Content-Type: application/json');
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(["success" => false, "message" => "Unsupported request method"]);
    exit;
}

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    error_log("Invalid user_id: $user_id");
    echo json_encode(["success" => false, "message" => "Invalid or missing user_id"]);
    exit;
}

try {
    // ✅ Directly query completed tasks (no transactions, faster & fresh)
    $query = "SELECT id, task_name, status, updated_at 
              FROM tasks 
              WHERE user_id = ? AND status = 'completed'
              ORDER BY updated_at DESC";

    $completed_stmt = $conn->prepare($query);
    $completed_stmt->bind_param("i", $user_id);
    $completed_stmt->execute();
    $result = $completed_stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            "task_id" => $row["id"],
            "task_name" => $row["task_name"],
            "status" => $row["status"],
            "updated_at" => $row["updated_at"]
        ];
    }
    $completed_stmt->close();

    // ✅ Count total
    $count_stmt = $conn->prepare("SELECT COUNT(*) as total FROM tasks WHERE user_id = ? AND status = 'completed'");
    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_completed = 0;
    if ($row = $count_result->fetch_assoc()) {
        $total_completed = intval($row["total"]);
    }
    $count_stmt->close();

    error_log("Completed tasks found for user $user_id: $total_completed");

    echo json_encode([
        "success" => true,
        "message" => empty($tasks) ? "No completed tasks found" : "Completed tasks retrieved successfully",
        "total_completed" => $total_completed,
        "tasks" => $tasks
    ]);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An error occurred: " . $e->getMessage()]);
}

$conn->close();
?>
