<?php
session_start();
if (!isset($_SESSION['admin'])) {
    die("Unauthorized.");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_path = getenv('DB_PATH') ?: '/var/sqlite/users.db';
    $db = new SQLite3($db_path);
    $stmt = $db->prepare("UPDATE users SET role = :role WHERE id = :id");
    $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
    $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>
