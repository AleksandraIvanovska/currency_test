FROM uselagoon/php-8.2-cli

WORKDIR /var/www/html/

#Generate key and set permissions
ENTRYPOINT composer install --ignore-platform-reqs && php artisan key:generate && mkdir -p storage/framework/sessions && php artisan serve
