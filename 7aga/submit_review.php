<?php

ini_set('display_errors', 0);       // Hide errors in output
ini_set('log_errors', 1);           // Log errors to a file
error_log("Error log enabled");     // Ensure it's logging

session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; // Get the user_id from session

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
$place_id = isset($data['place_id']) ? intval($data['place_id']) : 0;
$comment = isset($data['comment']) ? htmlspecialchars(trim($data['comment']), ENT_QUOTES, 'UTF-8') : '';

if ($place_id == 0 || empty($comment)) {
    echo json_encode(['error' => 'Invalid place ID or comment']);
    exit;
}

// Check if the user already has a review for the place
$stmt = $conn->prepare("SELECT id FROM reviews WHERE user_id = ? AND place_id = ?");
$stmt->bind_param("ii", $user_id, $place_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update the existing review
    $stmt = $conn->prepare("UPDATE reviews SET comment = ? WHERE user_id = ? AND place_id = ?");
    $stmt->bind_param("sii", $comment, $user_id, $place_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Review updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update review']);
    }
} else {
    // Insert a new review
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, place_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $place_id, $comment);
    if ($stmt->execute()) {
        echo json_encode(['success' => 'Review submitted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to submit review']);
    }
}

$stmt->close();
$conn->close();
?>
