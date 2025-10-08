// Best for fetching all tasks of a user by user_id
<?php
header('Content-Type: application/json');

include 'config.php';

$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($user_id <= 0) {
    echo json_encode(["success - get_tasks.php:19" => false, "message" => "Invalid or missing user_id"]);
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

echo json_encode([
    "success" => true,
    "tasks" => $tasks
]);

$stmt->close();
$conn->close();
?>
