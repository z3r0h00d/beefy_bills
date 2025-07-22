<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Unauthorized.");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new SQLite3('../data/users.db');
    $stmt = $db->prepare("UPDATE users SET role = :role WHERE id = :id");
    $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
    $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>
