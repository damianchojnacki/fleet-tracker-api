ARG PHP_EXTENSIONS="bcmath exif gd imap intl pdo_mysql sockets uuid redis imagick gd"

FROM thecodingmachine/php:8.2-v4-fpm

ENV PHP_EXTENSIONS="bcmath exif gd imap intl pdo_mysql sockets uuid redis imagick gd"

ENV TEMPLATE_PHP_INI=production
ENV PHP_INI_MEMORY_LIMIT=2g

RUN sudo apt-get update -y && \
    sudo apt-get install -y locales && \
    sudo locale-gen pl_PL.utf8 && \
    echo "LANG=pl_PL.utf8" >> ~/.bashrc && \
    sudo apt-get clean -y && \
    sudo apt-get autoremove -y

COPY --chown=docker:docker . /var/www/html
COPY --from=node --chown=docker:docker /usr/src/app/public/build /var/www/html/public/build

RUN composer install --no-interaction --optimize-autoloader
RUN php artisan storage:link

EXPOSE 9000
