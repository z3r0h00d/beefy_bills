<?php
session_start();
include("../includes/config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Beefy Bill's Burger Bar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Beefy Bill's Burger Bar 🍔</h1>
    <?php if(isset($_SESSION['username'])): ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
    <?php endif; ?>
</body>
</html>
