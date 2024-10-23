<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to the Dashboard <span id="userFirstName"><?php echo htmlspecialchars($_SESSION['firstName']); ?></span>.</h1>
    <p>You are logged in to the account <span id="userAccountID"><?php echo htmlspecialchars($_SESSION['accountID']); ?></span>.</p>
    <button id="logoutButton">Logout</button>

    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            window.location.href = 'logout.php'; // Redirect to logout.php
        });
    </script>
</body>
</html>
