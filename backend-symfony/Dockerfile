FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install intl zip

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY ./.docker/000-default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install

EXPOSE 80
