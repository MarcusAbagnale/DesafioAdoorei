FROM php:8.2.12-fpm

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install zip pdo_mysql \
    && apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY composer.json composer.lock ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.6.5

RUN set -eux; \
    composer install --no-scripts --no-autoloader --prefer-dist --no-interaction; \
    composer clear-cache

COPY . .

RUN composer dump-autoload --optimize

CMD php artisan serve --host=0.0.0.0 --port=8000
