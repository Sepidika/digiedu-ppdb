FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    curl nginx git unzip zip \
    libpng-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql gd xml zip mbstring \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/sites-available/default

EXPOSE 80
CMD php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan migrate --force && php-fpm -D && nginx -g 'daemon off;'