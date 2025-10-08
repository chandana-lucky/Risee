<?php
include "config.php";

// Check if file is uploaded
if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $filename = basename($image['name']);
    $targetDir = "uploads/";
    $targetFile = $targetDir . $filename;

    // Create uploads directory if not exists
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Move uploaded file
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO images (filename, filepath) VALUES (?, ?)");
        $stmt->bind_param("ss", $filename, $targetFile);
        if ($stmt->execute()) {
            echo json_encode(["success - show_images.php:22" => true, "message" => "Image uploaded successfully."]);
        } else {
            echo json_encode(["success - show_images.php:24" => false, "message" => "Database error."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success - show_images.php:28" => false, "message" => "Failed to move file."]);
    }
} else {
    echo json_encode(["success - show_images.php:31" => false, "message" => "No file uploaded."]);
}

$conn->close();
?>
