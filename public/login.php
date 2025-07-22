<?php
session_start();
include('/var/www/includes/config.php'); // Correct path to config
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = str_rot13($_POST['password']); // Apply ROT13 to match stored password

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);

    if ($stmt->execute()) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            $error = "User not registered.";
        } elseif ($user['password'] !== $password) {
            $error = "Incorrect password.";
        } else {
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: /admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }
    } else {
        $error = "Login query failed.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login - Beefy Bill's Burger Bar</title>
</head>
<body>
  <h2>Login</h2>
  <form method="post">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <input type="submit" value="Login">
  </form>
  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>
  <p><a href="register.php">Need an account? Register here.</a></p>
</body>
</html>
