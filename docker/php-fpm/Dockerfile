FROM php:fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install pdo_mysql

COPY php.ini $PHP_INI_DIR

CMD ["php-fpm"]

EXPOSE 9000

WORKDIR /var/www/