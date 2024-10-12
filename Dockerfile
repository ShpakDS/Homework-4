FROM php:8.3-cli

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

COPY ./src /var/www/html

CMD ["sh", "-c", "php /var/www/html/migrate.php && php -S 0.0.0.0:80 -t /var/www/html"]