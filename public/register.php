<?php
include('/var/www/includes/config.php');
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = str_rot13($_POST['password']);
    $lifeinvader = $_POST['lifeinvader'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);
    $stmt->execute();

    if ($stmt->fetch()) {
        $message = "Username already exists.";
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, password, role, lifeinvader, phone) 
                              VALUES (:username, :password, 'customer', :lifeinvader, :phone)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':lifeinvader', $lifeinvader);
        $stmt->bindValue(':phone', $phone);
        $stmt->execute();

        $message = "Registration successful! You can now <a href='login.php'>login</a>.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form method="post">
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br>
  LifeInvader Name: <input type="text" name="lifeinvader"><br>
  Phone Number: <input type="text" name="phone"><br>
  <input type="submit" value="Register">
</form>
<p><?= $message ?></p>
</body>
</html>
