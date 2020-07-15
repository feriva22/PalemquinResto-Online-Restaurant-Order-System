FROM php:7.3-apache

COPY . /var/www/html/

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite && service apache2 restart && \
    docker-php-ext-install mysqli
