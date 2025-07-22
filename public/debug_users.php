<?php
$dbPath = getenv('DB_PATH') ?: '/var/sqlite/users.db';
$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->query("SELECT username, password, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>User List</h2>";
echo "<ul>";
foreach ($users as $user) {
    echo "<li><strong>{$user['username']}</strong> (role: {$user['role']}) - ROT13 Password: {$user['password']}</li>";
}
echo "</ul>";
?>
