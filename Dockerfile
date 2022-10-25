FROM php:8.1-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN pecl install xdebug-3.1.4 && docker-php-ext-enable xdebug
