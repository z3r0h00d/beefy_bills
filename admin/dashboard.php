<?php
include(__DIR__ . '/../../includes/config.php');
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}

$stmt = $db->query("SELECT username, role, lifeinvader, phone FROM users ORDER BY username");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h1>Admin Dashboard</h1>
<table border="1">
    <tr><th>Username</th><th>Role</th><th>Lifeinvader</th><th>Phone</th></tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td><?= htmlspecialchars($user['lifeinvader']) ?></td>
        <td><?= htmlspecialchars($user['phone']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<a href="/logout.php">Logout</a>
</body>
</html>