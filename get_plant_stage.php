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

// Step 2: Define default stage information (including stage1_seed)
$base_url = "http://localhost/rise/";
$defaultStages = [
   
    ["min_day" => 1,  "max_day" => 6,  "stage_name" => "Seed in Sand", "image_url" => "stage1_seed.jpg"],
    ["min_day" => 7,  "max_day" => 12, "stage_name" => "Sprouting Leaf", "image_url" => "stage2_sprout.jpg"],
    ["min_day" => 13, "max_day" => 18, "stage_name" => "Leaf Grows", "image_url" => "stage3_leaf.jpg"],
    ["min_day" => 19, "max_day" => 24, "stage_name" => "Stem Forms", "image_url" => "stage4_stem.jpg"],
    ["min_day" => 25, "max_day" => 30, "stage_name" => "Full Plant", "image_url" => "stage5_fullplant.jpg"],

    
];

// Step 3: Try to get stage from database first
$stage = null;
$sql = "SELECT stage_name, image_url FROM plant_stages WHERE ? BETWEEN min_day AND max_day LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $totalCompleted);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stage = $result->fetch_assoc();
} else {
    // If not found in DB, use default stages
    foreach ($defaultStages as $s) {
        if ($totalCompleted >= $s['min_day'] && $totalCompleted <= $s['max_day']) {
            $stage = [
                "stage_name" => $s['stage_name'],
                "image_url" => $s['image_url']
            ];
            break;
        }
    }
}

if ($stage) {
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