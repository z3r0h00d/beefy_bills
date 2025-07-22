<?php
$dbPath = getenv('DB_PATH') ?: '/var/sqlite/users.db';
$db = new PDO("sqlite:$dbPath");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>