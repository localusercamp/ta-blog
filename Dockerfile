# syntax=docker/dockerfile:1

FROM composer:2.7 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
COPY app/helpers.php app/helpers.php
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

FROM php:8.3-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite headers \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY . .

RUN mkdir -p storage/smarty/compile storage/smarty/cache \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage

EXPOSE 80
