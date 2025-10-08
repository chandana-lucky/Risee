<?php
header('Content-Type: application/json');

include 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data["user_id"] ?? null;

if (!$user_id) {
    echo json_encode(["status - get_stage_by_user.php:17" => "error", "message" => "User ID required"]);
    exit;
}

// Get completed level of the user
$userQuery = $conn->prepare("SELECT completed_level FROM user_levels WHERE user_id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows == 0) {
    echo json_encode(["status - get_stage_by_user.php:28" => "error", "message" => "User not found or no level data"]);
    exit;
}

$userRow = $userResult->fetch_assoc();
$level = $userRow['completed_level'];

// Get corresponding plant stage
$stageQuery = $conn->prepare("SELECT * FROM plant_stages WHERE ? BETWEEN min_day AND max_day");
$stageQuery->bind_param("i", $level);
$stageQuery->execute();
$stageResult = $stageQuery->get_result();

if ($stageResult->num_rows == 0) {
    echo json_encode(["status - get_stage_by_user.php:42" => "error", "message" => "No stage found for this level"]);
    exit;
}

$stage = $stageResult->fetch_assoc();

echo json_encode([
    "status" => "success",
    "message" => "Stage retrieved successfully",
    "completed_level" => $level,
    "stage" => [
        "name" => $stage['stage_name'],
        "image" => $stage['image_url'],
        "range" => $stage['min_day'] . " - " . $stage['max_day']
    ]
]);
