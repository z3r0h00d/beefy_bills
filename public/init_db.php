<?php
// Load database path and raw password from environment variables
$dbPath = getenv('DB_PATH') ?: '/var/sqlite/users.db';
$rawPassword = getenv('RAW_PASSWORD');
if (!$rawPassword) {
  die("RAW_PASSWORD environment variable not set.");
}

// Encode password using ROT13
$encodedPassword = str_rot13($rawPassword);

// Connect to SQLite database
$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create 'users' table if it doesn't exist
$db->exec("
  CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT NOT NULL
  );
");

// Insert admin user if not already present
$stmt = $db->prepare("
  INSERT OR IGNORE INTO users (username, password, role)
  VALUES ('z3r0h00d', :password, 'admin')
");
$stmt->bindValue(':password', $encodedPassword);
$stmt->execute();

echo "Database initialized and superuser ensured.";
?>
