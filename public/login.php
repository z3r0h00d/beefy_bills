<?php
ob_start();
session_start();
header("Content-Type: text/html; charset=UTF-8");

include('/var/www/includes/config.php');
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = str_rot13($_POST['password']); // ROT13 transform

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);

    if ($stmt->execute()) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        file_put_contents('/tmp/login_debug.log', print_r([
            'username_input' => $username,
            'password_input_rot13' => $password,
            'password_db' => $user['password'] ?? 'N/A',
            'role' => $user['role'] ?? 'N/A',
            'password_match' => isset($user) && ($user['password'] === $password)
        ], true), FILE_APPEND);

        if (!$user) {
            $error = "User not registered.";
        } elseif ($user['password'] !== $password) {
            $error = "Incorrect password.";
        } else {
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];

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
  <meta charset="UTF-8">
  <title>Login - Beefy Bill&#39;s Burger Bar</title>
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
<?php ob_end_flush(); ?>
