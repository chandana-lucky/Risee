<?php
header("Content-Type: application/json");
include 'config.php';

// Get user ID
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($userId <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid or missing user ID"]);
    exit;
}

// Step 1: Count completed tasks from `tasks` table
$sql = "SELECT COUNT(*) AS completed_count FROM tasks WHERE user_id = ? AND status = 'completed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$totalCompleted = $row['completed_count'];

// Step 2: Match with plant stage
$sql = "SELECT stage_name, image_url FROM plant_stages WHERE ? BETWEEN min_day AND max_day LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $totalCompleted);
$stmt->execute();
$result = $stmt->get_result();

if ($stage = $result->fetch_assoc()) {
    $base_url = "http://localhost/rise/";
    echo json_encode([
        "success" => true,
        "user_id" => $userId,
        "total_completed" => $totalCompleted,
        "stage_name" => $stage['stage_name'],
        "image_url" => $base_url . $stage['image_url']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No plant stage found for task count",
        "total_completed" => $totalCompleted
    ]);
}
?>
