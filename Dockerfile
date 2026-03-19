FROM dunglas/frankenphp:php8.4-bookworm

# Install Node.js
RUN apt-get update && apt-get install -y curl && \
    curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs

RUN install-php-extensions \
    ctype curl dom fileinfo filter gd hash mbstring openssl pcre pdo pdo_mysql session tokenizer xml zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build
RUN mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache

EXPOSE 80
CMD php artisan config:clear && php artisan cache:clear && php artisan migrate --force && frankenphp run --config /app/Caddyfile