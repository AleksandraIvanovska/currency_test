FROM uselagoon/php-8.2-cli

WORKDIR /var/www/html/

RUN apk add --no-cache aws-cli

#Generate key and set permissions
ENTRYPOINT composer install --ignore-platform-reqs && php artisan key:generate && mkdir -p storage/framework/sessions && php artisan serve

## Use an official PHP runtime as a parent image
#FROM php:7.4-fpm
#
## Set the working directory in the container
#WORKDIR /var/www/html
#
## Copy the local Laravel application to the container's working directory
#COPY . .
#
## Install PHP extensions and dependencies required for Laravel
#RUN apt-get update && apt-get install -y \
#    libpng-dev \
#    libjpeg-dev \
#    libfreetype6-dev \
#    zip \
#    unzip \
#    && docker-php-ext-configure gd --with-freetype --with-jpeg \
#    && docker-php-ext-install gd pdo pdo_mysql
#
## Install Composer globally
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#
## Install required Composer dependencies for Laravel
#RUN composer install
#
## Expose port 9000 (used by PHP-FPM)
#EXPOSE 9000
#
## Start the PHP-FPM process
#CMD ["php-fpm"]
