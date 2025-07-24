#!/bin/bash
DB_PATH="/var/sqlite/users.db"

if [ ! -f "$DB_PATH" ]; then
  echo "Creating SQLite DB..."
  sqlite3 "$DB_PATH" "CREATE TABLE IF NOT EXISTS users (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      username TEXT NOT NULL UNIQUE,
      password TEXT NOT NULL,
      role TEXT NOT NULL,
      lifeinvader TEXT,
      phone TEXT
  );"
  echo "DB initialized."
else
  echo "DB already exists."
fi
chmod 664 "$DB_PATH"
chown www-data:www-data "$DB_PATH"