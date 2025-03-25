FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libonig-dev \
    libicu-dev autoconf pkg-config libssl-dev \
    libxml2-dev libpng-dev libpq-dev \
    nodejs npm && \
    docker-php-ext-install bcmath mbstring intl opcache zip pdo pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
