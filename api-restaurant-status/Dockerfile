# php
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql sockets

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

COPY .env.example .env

RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache

# RUN php artisan config:clear

EXPOSE 8000

CMD composer install && php artisan serve --host=0.0.0.0 --port=8000
