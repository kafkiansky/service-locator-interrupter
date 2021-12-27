FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev \
    openssl

RUN docker-php-ext-install bcmath zip sockets pcntl

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www