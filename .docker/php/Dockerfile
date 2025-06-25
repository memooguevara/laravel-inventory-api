FROM composer:2.8.4 AS composer
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instalar Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install

# Permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data storage bootstrap/cache
