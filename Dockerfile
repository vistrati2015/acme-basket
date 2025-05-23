FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    wget

RUN docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd

WORKDIR /app
COPY --chown=www-data:www-data . /app

RUN wget https://getcomposer.org/download/latest-stable/composer.phar \
    && chmod +x composer.phar \
    && mv composer.phar /usr/local/bin/composer \
    && apk del wget

RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm", "-F"]