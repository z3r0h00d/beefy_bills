<?php
include('/var/www/includes/config.php');
include('/var/www/includes/auth.php');

// Fetch all users
$stmt = $db->query("SELECT username, role FROM users ORDER BY username");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard (Read Only)</h1>
    <p>Below is a list of users and their assigned roles. Role editing is currently disabled.</p>
    <table border="1">
        <tr><th>Username</th><th>Role</th></tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td>
                <select disabled>
                    <option value="admin"<?= $user['role'] === 'admin' ? ' selected' : '' ?>>Admin</option>
                    <option value="boosting"<?= $user['role'] === 'boosting' ? ' selected' : '' ?>>Boosting</option>
                    <option value="racing"<?= $user['role'] === 'racing' ? ' selected' : '' ?>>Racing</option>
                    <option value="customer"<?= $user['role'] === 'customer' ? ' selected' : '' ?>>Customer</option>
                </select>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="/logout.php">Logout</a>
</body>
</html>
