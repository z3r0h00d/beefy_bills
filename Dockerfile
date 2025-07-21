# Use official PHP-Apache image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install PDO SQLite extension
RUN docker-php-ext-install pdo pdo_sqlite

# Copy public files to Apache root
COPY public/ /var/www/html/

# Copy includes and data to a safe directory
COPY includes/ /var/www/includes/
COPY data/ /var/www/data/

# Give Apache permission to access includes and data
RUN chown -R www-data:www-data /var/www/includes /var/www/data

# Expose port
EXPOSE 80
