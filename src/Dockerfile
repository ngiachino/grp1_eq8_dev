FROM php:7.3-apache

RUN docker-php-ext-install opcache
RUN docker-php-ext-install mysqli

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html/

COPY . .

COPY database/logs.docker.php database/logs.php
