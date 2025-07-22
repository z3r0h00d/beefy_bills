FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

COPY public/ /var/www/html/
COPY includes/ /var/www/includes/
COPY data/ /var/www/data/

RUN mkdir -p /var/sqlite && chown -R www-data:www-data /var/www/html /var/www/includes /var/sqlite

EXPOSE 80
