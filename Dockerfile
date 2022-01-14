FROM php:8

RUN apt-get update && apt-get install -y \
    && docker-php-ext-install mysqli pdo_mysql sockets