<?php
session_start();
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_path = getenv('DB_PATH') ?: '/var/sqlite/users.db';
    $db = new SQLite3($db_path);
    $username = $_POST['username'];
    $password = str_rot13($_POST['password']);

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password AND role = 'admin'");
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
    if ($user) {
        $_SESSION['admin'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
<h2>Admin Login</h2>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
<p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
