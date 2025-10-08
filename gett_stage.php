 <?php
header("Content-Type: application/json");
include 'config.php';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($userId <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid user ID"]);
    exit;
}

// 1. Count completed tasks
$countQuery = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE user_id = ? AND status = 'completed'");
$countQuery->bind_param("i", $userId);
$countQuery->execute();
$countResult = $countQuery->get_result();
$totalCompleted = $countResult->fetch_assoc()['total'];

// 2. Get current plant stage
$stageQuery = $conn->prepare("SELECT stage_name, image_url FROM plant_stages WHERE ? BETWEEN min_day AND max_day LIMIT 1");
$stageQuery->bind_param("i", $totalCompleted);
$stageQuery->execute();
$stageResult = $stageQuery->get_result();

if ($stageResult->num_rows > 0) {
    $stage = $stageResult->fetch_assoc();
    
    // Return relative image path (without base URL)
    echo json_encode([
        "success" => true,
        "user_id" => $userId,
        "total_completed" => $totalCompleted,
        "stage_name" => $stage['stage_name'],
        "image_url" => $stage['image_url'] // e.g. "crt/stage1_seed.png"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No growth stage found for completed tasks: " . $totalCompleted,
        "total_completed" => $totalCompleted
    ]);
}
?>