FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    zip \
    libpq-dev \
    && docker-php-ext-install \
        intl \
        pdo \
        pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www