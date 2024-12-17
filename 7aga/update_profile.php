<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$user_id = $_SESSION["user_id"];

// Sanitize and retrieve the updated values from the form
$newUsername = $conn->real_escape_string($_POST["username"]);
$newEmail = $conn->real_escape_string($_POST["email"]);
$newPassword = $_POST["password"];

// If a new password is entered, hash it
if (!empty($newPassword)) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$newUsername', email='$newEmail', password='$hashedPassword' WHERE id=$user_id";
} else {
    // If no new password, update only username and email
    $sql = "UPDATE users SET username='$newUsername', email='$newEmail' WHERE id=$user_id";
}

// Execute the update query
if ($conn->query($sql) === TRUE) {
    echo "Profile updated successfully!";
    // Optionally, you can redirect to profile page or show success message
    header("Location: login.html");
} else {
    echo "Error: " . $conn->error;
}

// Close connection
$conn->close();
?>
