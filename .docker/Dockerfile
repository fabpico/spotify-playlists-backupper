FROM php:8.1-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update
RUN apt-get install --yes git
RUN apt-get install --yes libzip-dev zip && docker-php-ext-install zip
RUN pecl install xdebug-3.1.4 && docker-php-ext-enable xdebug