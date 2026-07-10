#!/bin/sh

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

if [ -z "$(grep 'APP_KEY=' .env | cut -d '=' -f2)" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force

php-fpm
