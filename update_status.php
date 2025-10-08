<?php
header('Content-Type: application/json');
include 'config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    $id = isset($data['id']) ? intval($data['id']) : 0;
    $status = isset($data['status']) ? $data['status'] : null;

    if ($id <= 0 || empty($status)) {
        $response["success"] = false;
        $response["message"] = "ID or status is missing";
    } else {
        $stmt = $conn->prepare("UPDATE tasks SET status = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $status, $id);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $response["success"] = true;
            $response["message"] = "Task status updated";
            $response["id"] = $id;
        } else {
            $response["success"] = false;
            $response["message"] = "DB update failed or ID not found";
        }

        $stmt->close();
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request method";
}

$conn->close();
echo json_encode($response);
?>
