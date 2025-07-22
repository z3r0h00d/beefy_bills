FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Copy your app's public & include files
COPY public/ /var/www/html/
COPY includes/ /var/www/html/includes/

# Copy admin panel
COPY admin/ /var/www/html/admin/

# Ensure DB folder exists (mounted or fallback)
RUN mkdir -p /var/sqlite && chown -R www-data:www-data /var/www/html /var/sqlite

EXPOSE 80
