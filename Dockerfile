# Dockerfile
FROM php:8.3-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Node.js + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel app with www-data ownership
COPY --chown=www-data:www-data src/ .

# Install dependencies and build frontend assets inside the image so a fresh
# checkout does not depend on ignored vendor, node_modules, or public/build files.
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install \
    && npm run build \
    && mkdir -p /opt/booking-build \
    && cp -a public/build/. /opt/booking-build/

EXPOSE 9000

CMD ["sh", "-c", "mkdir -p public/build && cp -a /opt/booking-build/. public/build/ && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache && exec php-fpm"]
