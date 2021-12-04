FROM php:8.0.5-fpm-alpine

WORKDIR "/var/www/app"

RUN apk update

RUN apk add --no-cache $PHPIZE_DEPS
RUN apk add --no-cache zlib-dev
RUN apk add --no-cache libxml2-dev
RUN apk add --no-cache gmp-dev
RUN apk add --no-cache icu-dev zip
RUN apk add --no-cache zip
RUN apk add --no-cache libssh-dev
RUN apk add --no-cache bash
RUN apk add --no-cache openssh
RUN apk add --no-cache libmcrypt-dev

RUN apk add --no-cache git
RUN apk add --no-cache vim

RUN docker-php-ext-install intl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache
#RUN docker-php-ext-install zip
RUN docker-php-ext-install gmp
RUN docker-php-ext-install pcntl

# mysql
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#install blackfire
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/alpine/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz
