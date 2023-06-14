FROM php:8.2.7-fpm-alpine3.18

RUN addgroup -S nginx && adduser -S nginx -G nginx

RUN apk add --no-cache mysql-client msmtp perl wget procps shadow libzip libpng libjpeg-turbo libwebp freetype icu

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev unzip && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip && \
    docker-php-ext-install bcmath && \
    apk del build-essentials && rm -rf /usr/src/php*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV TZ Asia/Tokyo

COPY infra/conf/php/zzz-docker.conf /usr/local/etc/php-fpm.d/zzz-docker.conf
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN mkdir /var/run/php-fpm
VOLUME ["/var/run/php-fpm"]

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-dev && \
    php artisan cache:clear && \
    php artisan config:clear && \
    php artisan route:cache && \
    chmod -R 777 storage