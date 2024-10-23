<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database connection parameters
$servername = "mysql";  // The name of the MySQL service in Docker Compose
$username = "root";      // MySQL user from Docker Compose
$password = "rootpassword"; // MySQL password from Docker Compose
$dbname = "app_db";      // MySQL database name from Docker Compose

// Create a PDO connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Get user input
$usernameInput = $_POST['username'];
$passwordInput = $_POST['password'];

// Check credentials
$valid = false;
$firstName = "";
$accountID = "";

$sql = "SELECT account_id, first_name FROM credentials WHERE username = :username AND password = :password";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $usernameInput);
    $stmt->bindParam(':password', $passwordInput);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $valid = true;
        $firstName = $user['first_name'];
        $accountID = $user['account_id'];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;

if ($valid) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['accountID'] = $accountID;

    // Redirect to the dashboard
    header("Location: dashboard.php"); // Change this to a PHP file for session management
    exit();
} else {
    echo '<script>alert("Invalid credentials, try again."); window.location.href="login.html";</script>';
}
?>
