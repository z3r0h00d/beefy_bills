<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit();
}

include('/var/www/html/includes/config.php');

// Handle role update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['role'])) {
    $username = $_POST['username'];
    $newRole = $_POST['role'];
    $validRoles = ['admin', 'boosting', 'racing', 'customer'];

    if (in_array($newRole, $validRoles)) {
        $stmt = $db->prepare("UPDATE users SET role = :role WHERE username = :username");
        $stmt->execute([':role' => $newRole, ':username' => $username]);
    }
}

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
    <p>Hello, <?= htmlspecialchars($_SESSION['user']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</p>
    <p>You can change user roles using the dropdowns below:</p>

    <table border="1">
        <tr><th>Username</th><th>Role</th><th>Action</th></tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <form method="POST" action="dashboard.php">
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                    <input type="hidden" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                    <select name="role">
                        <option value="admin"<?= $user['role'] === 'admin' ? ' selected' : '' ?>>Admin</option>
                        <option value="boosting"<?= $user['role'] === 'boosting' ? ' selected' : '' ?>>Boosting</option>
                        <option value="racing"<?= $user['role'] === 'racing' ? ' selected' : '' ?>>Racing</option>
                        <option value="customer"<?= $user['role'] === 'customer' ? ' selected' : '' ?>>Customer</option>
                    </select>
                </td>
                <td><button type="submit">Update</button></td>
            </form>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="/index.php">Return to Main Page</a> |
    <a href="/logout.php">Logout</a>
</body>
</html>

