FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    curl \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN chmod +x /var/www/entrypoint.sh

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www && \
    chmod -R 755 /var/www/storage

CMD ["php-fpm"]
