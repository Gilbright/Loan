FROM php:7.2.13-fpm-alpine3.8

WORKDIR "/application"

RUN apk update

RUN apk add --no-cache $PHPIZE_DEPS
RUN echo extension=mongodb.so >> /usr/local/etc/php/conf.d/mongodb.ini
RUN apk add --no-cache zlib-dev
RUN apk add --no-cache libxml2-dev
RUN apk add --no-cache gmp-dev
RUN apk add --no-cache libmemcached-dev
RUN apk add --no-cache icu-dev zip
RUN apk add --no-cache zip
RUN apk add --no-cache rabbitmq-c-dev
RUN apk add --no-cache libssh-dev
RUN apk add --no-cache libmcrypt-dev
RUN apk add --no-cache bash
RUN apk add --no-cache openssh

RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

RUN pecl install mcrypt-1.0.1
RUN echo extension=mcrypt.so >> /usr/local/etc/php/conf.d/mcrypt.ini

RUN apk add --no-cache git
RUN apk add --no-cache vim

RUN docker-php-ext-install intl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install opcache
RUN docker-php-ext-install zip
RUN docker-php-ext-install soap
RUN docker-php-ext-install gmp
RUN docker-php-ext-install sockets

RUN pecl install mongodb
RUN echo extension=mongodb.so >> /usr/local/etc/php/conf.d/mongodb.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
