<?php
//http://127.0.0.1:3306/rise/get_pending_tasks.php

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
    // Start transaction to ensure atomicity
    $conn->begin_transaction();

    // Step 1: Get task IDs with status 'planned'
    $select_planned = $conn->prepare("SELECT id FROM tasks WHERE user_id = ? AND status = 'planned'");
    $select_planned->bind_param("i", $user_id);
    $select_planned->execute();
    $result = $select_planned->get_result();

    $task_ids_to_update = [];
    while ($row = $result->fetch_assoc()) {
        $task_ids_to_update[] = $row['id'];
    }
    $select_planned->close();

    error_log("Planned Task IDs for user $user_id: " . implode(',', $task_ids_to_update));

    // Step 2: Update tasks to 'pending' using a prepared statement
    if (!empty($task_ids_to_update)) {
        $placeholders = implode(',', array_fill(0, count($task_ids_to_update), '?'));
        $update_stmt = $conn->prepare("UPDATE tasks SET status = 'pending' WHERE id IN ($placeholders)");
        $update_stmt->bind_param(str_repeat('i', count($task_ids_to_update)), ...$task_ids_to_update);

        if (!$update_stmt->execute()) {
            throw new Exception("Update failed: " . $update_stmt->error);
        }
        $update_stmt->close();
        error_log("Updated " . count($task_ids_to_update) . " tasks to pending for user $user_id");
    } else {
        error_log("No planned tasks found for user $user_id");
    }

    // Step 3: Fetch all 'pending' tasks
    $pending_stmt = $conn->prepare("SELECT id, task_name, status FROM tasks WHERE user_id = ? AND status = 'pending'");
    $pending_stmt->bind_param("i", $user_id);
    $pending_stmt->execute();
    $result = $pending_stmt->get_result();

    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = [
            "task_id" => $row["id"],
            "task_name" => $row["task_name"],
            "status" => $row["status"]
        ];
    }
    $pending_stmt->close();

    error_log("Pending tasks found: " . count($tasks));

    // Commit transaction
    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => empty($task_ids_to_update) ? "No tasks updated" : "Tasks updated successfully",
        "tasks" => $tasks
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    error_log("Error: " . $e->getMessage());
    echo json_encode(["success" => false, "message" => "An error occurred: " . $e->getMessage()]);
}

$conn->close();
?>