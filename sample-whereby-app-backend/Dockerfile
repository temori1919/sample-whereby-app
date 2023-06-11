FROM php:8.2.6-apache-buster

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git

RUN docker-php-ext-install -j "$(nproc)" opcache && docker-php-ext-enable opcache

RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=composer:2.5.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . ./
RUN composer install --optimize-autoloader --no-dev
# RUN $(which php) artisan cache:clear
# RUN $(which php) artisan config:cache
# RUN $(which php) artisan route:cache
RUN chown -Rf www-data:www-data ./