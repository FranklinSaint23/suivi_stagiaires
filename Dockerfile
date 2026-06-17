FROM php:8.4-cli

# Dépendances système + libs pour extensions PHP
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev \
    libpq-dev libzip-dev \
    libfreetype6-dev libjpeg62-turbo-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_pgsql pdo_mysql mbstring \
        exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Dépendances PHP
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Code source (assets déjà buildés dans public/build/)
COPY . .

RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8080

CMD php artisan optimize:clear && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=8080
