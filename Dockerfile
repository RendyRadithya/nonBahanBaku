# Multi-stage Dockerfile for Laravel app on Railway
# Stage 1: Build frontend assets with Node
FROM node:18-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --silent
COPY . .
RUN npm run build

# Stage 2: Install PHP dependencies with Composer
FROM php:8.2-cli AS composer
WORKDIR /app

# Install system deps required for Composer and some PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git curl unzip zip libzip-dev && rm -rf /var/lib/apt/lists/*

# Install composer (global)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json ./
COPY composer.lock ./

# Install PHP dependencies using PHP 8.2 so platform requirements match
# Use --no-scripts so composer doesn't try to run artisan before app files are copied
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts

COPY . .
COPY --from=node-builder /app/public /app/public

# Now that application files (including artisan) are present, run scripts that require it
RUN composer dump-autoload --optimize && \
    if [ -f artisan ]; then php artisan package:discover --ansi || true; fi

# Final stage: runtime image
FROM php:8.2-cli
WORKDIR /app

# system deps
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev zip unzip git libpng-dev libonig-dev && \
    docker-php-ext-install pdo pdo_mysql mbstring zip gd && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# copy app from composer stage
COPY --from=composer /app /app

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache || true

ENV APP_ENV=production
EXPOSE 8080

# Run the Laravel built-in server (sufficient for Railway container) on port 8080
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8080"]
