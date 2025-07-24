FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libsqlite3-dev sqlite3 && \
    docker-php-ext-install pdo pdo_sqlite

COPY public/ /var/www/html/
COPY includes/ /var/www/html/includes/
COPY init-db.sh /docker-entrypoint-init.d/

RUN mkdir -p /var/sqlite && \
    chown -R www-data:www-data /var/www/html /var/sqlite

EXPOSE 80