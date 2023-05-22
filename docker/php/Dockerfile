FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev \
    && apt-get install -y libmagickwand-dev --no-install-recommends ghostscript --no-install-recommends \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu imagick \
    && docker-php-ext-enable apcu imagick \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get purge -y libmagickwand-dev

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer