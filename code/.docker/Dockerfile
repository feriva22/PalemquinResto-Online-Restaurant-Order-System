FROM php:7.3.12-apache

MAINTAINER Ferico Deno Vandra

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /srv/app

RUN a2enmod rewrite && service apache2 restart && \
    docker-php-ext-install mbstring mysqli \
    && chown -R www-data:www-data /srv/app