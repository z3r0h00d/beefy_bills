# Use official PHP-Apache image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install SQLite dev libraries for PDO_SQLITE support
RUN apt-get update && \
    apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Copy site files into container
COPY public/ /var/www/html/
COPY includes/ /var/www/includes/
COPY data/ /var/www/data/

# Fix permissions
RUN chown -R www-data:www-data /var/www/includes /var/www/data

# Expose port
EXPOSE 80
