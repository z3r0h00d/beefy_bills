<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$db = new SQLite3('../data/users.db');
$users = $db->query("SELECT id, username, role FROM users");
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['admin']; ?> | <a href="logout.php">Logout</a></p>
<table border="1">
<tr><th>Username</th><th>Role</th><th>Change Role</th></tr>
<?php while ($row = $users->fetchArray(SQLITE3_ASSOC)): ?>
<tr>
  <form method="post" action="update_role.php">
    <td><?php echo htmlspecialchars($row['username']); ?></td>
    <td><?php echo htmlspecialchars($row['role']); ?></td>
    <td>
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <input type="submit" value="Update">
    </td>
  </form>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
