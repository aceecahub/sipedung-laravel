FROM php:8.3-fpm

# Install dependency
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===== Create user non-root =====
RUN groupadd -g 1000 laravel \
 && useradd -u 1000 -g laravel -m laravel

WORKDIR /var/www

# Pastikan ownership benar
RUN chown -R laravel:laravel /var/www

# Pakai user laravel (BUKAN root)
USER laravel
