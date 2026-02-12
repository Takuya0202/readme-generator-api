FROM php:8.4
WORKDIR /api
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt-get update \
    && apt-get install -y zip \
    && docker-php-ext-install pdo_mysql
COPY . .
WORKDIR /api/src
RUN composer install
CMD ["php", "artisan", "serve" , "--host" , "0.0.0.0"]
EXPOSE 8000