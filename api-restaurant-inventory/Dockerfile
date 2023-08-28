# php
FROM php:8.1-fpm

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
COPY api-restaurant-inventory /var/www/html
RUN composer install