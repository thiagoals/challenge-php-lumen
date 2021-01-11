FROM php:7.3-fpm-alpine

#Extensões do Lumen
RUN docker-php-ext-install mbstring tokenizer mysqli pdo_mysql sockets

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer