ARG PHP_EXTENSIONS="bcmath gd imap intl pdo_mysql uuid igbinary redis sqlite3"

FROM thecodingmachine/php:8.2-v4-slim-fpm

ENV PHP_EXTENSIONS="bcmath gd imap intl pdo_mysql uuid igbinary redis sqlite3"

ENV TEMPLATE_PHP_INI=production
ENV PHP_INI_MEMORY_LIMIT=2g

COPY --chown=docker:docker ../.. /var/www/html

RUN composer install --no-interaction --optimize-autoloader
RUN php artisan storage:link

EXPOSE 9000
