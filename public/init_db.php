<?php
$dbPath = getenv('DB_PATH') ?: '/var/sqlite/users.db';
$rawPassword = getenv('RAW_PASSWORD') ?: 'changeme';
$encodedPassword = str_rot13($rawPassword);

$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create table
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL
  );
");

// Create superuser
$db->exec("
  INSERT OR IGNORE INTO users (username, password, role)
  VALUES ('z3r0h00d', '$encodedPassword', 'admin');
");

echo "Database initialized and superuser created.";
?>
