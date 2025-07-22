<?php
$db_path = getenv('DB_PATH') ?: '/var/sqlite/users.db';
$db = new SQLite3($db_path);

$username = 'z3r0h00d';
$raw_password = 'hunter2';
$encoded_password = str_rot13($raw_password);
$role = 'admin';

$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result->fetchArray()) {
    echo "User already exists.";
    exit;
}

$stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $encoded_password, SQLITE3_TEXT);
$stmt->bindValue(':role', $role, SQLITE3_TEXT);
$stmt->execute();

echo "Admin user '$username' created successfully with ROT13 password.";
?>
