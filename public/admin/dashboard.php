<?php
session_start();

// Redirect if user is not logged in or not an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit();
}

include('/var/www/includes/config.php');

// Fetch all users
$stmt = $db->query("SELECT username, role FROM users ORDER BY username");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Beefy Bill&#39;s Burger Bar</title>
</head>
<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['user']); ?> (<?php echo htmlspecialchars($_SESSION['role']); ?>)</p>
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
    <a href="/index.php">Return to Main Page</a> |
    <a href="/logout.php">Logout</a>
</body>
</html>
