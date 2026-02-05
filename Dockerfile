FROM php:8.4-apache
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli
COPY htdocs/ /var/www/html/
