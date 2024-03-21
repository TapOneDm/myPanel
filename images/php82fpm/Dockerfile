FROM php:8.2-fpm

RUN apt-get update
RUN apt-get install -y curl git zip libpq-dev bash libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_pgsql
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chown -R www-data:www-data /var/www
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

USER "1000:1000"

WORKDIR /var/www

ENTRYPOINT [ "php-fpm" ]