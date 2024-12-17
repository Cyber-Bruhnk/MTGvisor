<?php
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user data
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            
            // Start session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['logged_in'] = true;

            //redirect to dashboard
            header('Location: home.html');
            exit; // Ensure the script stops after the redirect
        } else {
            // Password is incorrect, show alert
            echo "<script>alert('Incorrect password.'); window.location.href='login.html';</script>";
        }
    } else {
        // Email does not exist, show alert
        echo "<script>alert('No account found with that email.'); window.location.href='login.html';</script>";
    }
}

// Close connection
$conn->close();
?>
