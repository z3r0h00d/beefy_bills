FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update &&     apt-get install -y libsqlite3-dev &&     docker-php-ext-install pdo pdo_sqlite

COPY admin/ /var/www/html/admin/

RUN chown -R www-data:www-data /var/www/html/admin

EXPOSE 80
