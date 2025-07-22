FROM php:8.2-apache

WORKDIR /var/www/html

# Install SQLite CLI and PHP SQLite support
RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Copy site files
COPY public/ /var/www/html/
COPY includes/ /var/www/html/includes/

# Create database directory and initialize schema
RUN mkdir -p /var/sqlite && \
    touch /var/sqlite/users.db && \
    sqlite3 /var/sqlite/users.db "\
      CREATE TABLE IF NOT EXISTS users (\
        id INTEGER PRIMARY KEY AUTOINCREMENT,\
        username TEXT NOT NULL UNIQUE,\
        password TEXT NOT NULL,\
        role TEXT NOT NULL,\
        lifeinvader TEXT,\
        phone TEXT\
      );" && \
    chown -R www-data:www-data /var/www/html /var/sqlite

EXPOSE 80

