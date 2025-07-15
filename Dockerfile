FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip libpq-dev libzip-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
