<?php

ini_set('display_errors', 0);       // Hide errors in output
ini_set('log_errors', 1);           // Log errors to a file
error_log("Error log enabled");     // Ensure it's logging

header('Content-Type: application/json');  // Tell the browser to expect JSON
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$place_id = isset($_GET['place_id']) ? intval($_GET['place_id']) : 0;


if ($place_id === 0) {
    echo json_encode(["error" => "No place_id provided!"]);
    exit;
}

try {
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT reviews.comment, users.username 
                            FROM reviews 
                            JOIN users ON reviews.user_id = users.id 
                            WHERE reviews.place_id = ?");
    $stmt->bind_param("i", $place_id);  // Bind $place_id as integer
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    if (empty($reviews)) {
        echo json_encode(["message" => "No reviews found for this place!"]);
    } else {
        echo json_encode($reviews);
    }
} catch (Exception $e) {
    // Handle unexpected errors
    echo json_encode(["error" => "An error occurred: " . $e->getMessage()]);
}