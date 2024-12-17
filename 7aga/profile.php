<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html"); // Redirect to login page if not logged in
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

// Fetch user data using the session's user_id
$user_id = $_SESSION["user_id"]; // Get the logged-in user's ID
$sql = "SELECT username, email FROM users WHERE id = $user_id"; // Query to fetch user details
$result = $conn->query($sql);

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch the user data
    $currentUsername = $user['username']; // Store username
    $currentEmail = $user['email']; // Store email
} else {
    echo "User not found.";
    exit();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    
<div className="bg-white shadow-lg rounded-lg p-8 flex-1 border-l-4 border-green-500">
        <a href="home.html" class="bg-blue-600 text-white px-2 py-1 rounded-lg hover:bg-blue-700">Back to Home</a>
        <form class="profile-form" action="update_profile.php" method="POST">
            <h1>Update Profile</h1>

            <!-- Populate the form with user data from PHP -->
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($currentUsername); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($currentEmail); ?>" required>

            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm new password">

            <button type="submit">Update Profile</button>
        </form>
    </div>

    <script src="profile.js"></script>
</body>
</html>
