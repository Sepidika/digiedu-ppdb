FROM dunglas/frankenphp:php8.4-bookworm

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
CMD ["frankenphp", "run", "--config", "/app/Caddyfile"]