<?php
header('Content-Type: application/json');

include 'config.php';

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);
$user_id = $data["user_id"] ?? null;
$completed_level = $data["completed_level"] ?? null;

if (!$user_id || !$completed_level) {
    echo json_encode(["status - update_user_level.php:17" => "error", "message" => "Missing user_id or completed_level"]);
    exit;
}

// Check if record exists
$checkStmt = $conn->prepare("SELECT completed_level FROM user_levels WHERE user_id = ?");
$checkStmt->bind_param("i", $user_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_level = $row['completed_level'];

    // Only update if the new level is higher
    if ($completed_level > $current_level) {
        $updateStmt = $conn->prepare("UPDATE user_levels SET completed_level = ?, updated_at = NOW() WHERE user_id = ?");
        $updateStmt->bind_param("ii", $completed_level, $user_id);
        $updateStmt->execute();

        echo json_encode(["status - update_user_level.php:37" => "success", "message" => "Level updated to " . $completed_level]);
    } else {
        echo json_encode(["status - update_user_level.php:39" => "success", "message" => "Level not updated. Existing level is higher or equal."]);
    }
} else {
    // Insert new record
    $insertStmt = $conn->prepare("INSERT INTO user_levels (user_id, completed_level) VALUES (?, ?)");
    $insertStmt->bind_param("ii", $user_id, $completed_level);
    $insertStmt->execute();

    echo json_encode(["status - update_user_level.php:47" => "success", "message" => "New user level inserted"]);
}

$conn->close();
