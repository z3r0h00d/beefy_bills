<?php
session_start();
include(__DIR__ . '/includes/config.php');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = str_rot13($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);

    if ($stmt->execute()) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            $error = "❌ User not registered.";
        } elseif ($user['password'] !== $password) {
            $error = "🔐 Incorrect password.";
        } else {
            $_SESSION['user'] = $user['username'];
            header("Location: index.php");
            exit();
        }
    } else {
        $error = "⚠️ Login query failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
<form method="post">
  Username: <input type="text" name="username" required><br>
  Password: <input type="password" name="password" required><br>
  <input type="submit" value="Login">
</form>
<p style="color:red;"><?php echo $error; ?></p>
<p><a href="register.php">Need an account? Register here.</a></p>
</body>
</html>
