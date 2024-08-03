<?php
session_start();
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "login_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = md5($password);

    // Check if user exists
    $sql = "SELECT id FROM users WHERE email='$email' AND password='$hashed_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login success
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // Login failed
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
}

$conn->close();
?>
