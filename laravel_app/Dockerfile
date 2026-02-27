FROM php:8.2-cli-alpine

# Dependencias del sistema
RUN apk add --no-cache curl git unzip oniguruma-dev libxml2-dev

# Extensiones PHP requeridas por Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring xml

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Crear proyecto Laravel limpio
RUN composer create-project laravel/laravel /app \
    --prefer-dist --no-progress --no-interaction

WORKDIR /app

# Copiar nuestros archivos personalizados encima del scaffold de Laravel
COPY src/routes/web.php            routes/web.php
COPY src/app/Http/Controllers/     app/Http/Controllers/
COPY src/resources/views/          resources/views/
COPY src/public/css/               public/css/

# Permisos de escritura para Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
