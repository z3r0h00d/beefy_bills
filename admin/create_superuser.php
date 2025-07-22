<?php
$db = new SQLite3('data/users.db');

$username = 'z3r0h00d';
$raw_password = $raw_password;
$encoded_password = str_rot13($raw_password);
$role = 'admin';

// Check if user already exists
$stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result->fetchArray()) {
    echo "User already exists.";
    exit;
}

// Insert admin user with ROT13 password
$stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $encoded_password, SQLITE3_TEXT);
$stmt->bindValue(':role', $role, SQLITE3_TEXT);
$stmt->execute();

echo "Admin user '$username' created successfully with ROT13 password.";
?>
