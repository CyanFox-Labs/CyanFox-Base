FROM php:8.2-fpm-alpine

# Install Dockerize
ARG DOCKERIZE_VERSION=0.6.1

# Use the build argument to dynamically determine the architecture
RUN set -eux; \
    ARCH=$(uname -m); \
    if [ "$ARCH" = "x86_64" ]; then ARCH="amd64"; fi; \
    if [ "$ARCH" = "aarch64" ]; then ARCH="arm64"; fi; \
    wget https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-alpine-linux-$ARCH-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-$ARCH-v$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-$ARCH-v$DOCKERIZE_VERSION.tar.gz


# Install packages
RUN apk --no-cache add \
    php \
    php-fpm \
    php-opcache \
    php-pdo_mysql \
    php-pdo_pgsql \
    php-pgsql \
    php-pcntl \
    php-exif \
    php-intl \
    php-openssl \
    php-pecl-apcu \
    php-pecl-redis \
    php-common \
    php-iconv \
    php-json \
    php-mbstring \
    php-xml \
    php-bcmath \
    php-curl \
    php-ctype \
    php-dom \
    php-tokenizer \
    php-fileinfo \
    php-xmlwriter \
    php-xmlreader \
    php-simplexml \
    php-gd \
    libpng-dev libjpeg-turbo-dev freetype-dev \
    composer \
    nodejs \
    npm \
    nginx

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd pdo_mysql

COPY . /var/www
WORKDIR /var/www

COPY docker/nginx.conf /etc/nginx/nginx.conf

CMD ["sh", "-c", "php-fpm -D; nginx -g 'daemon off;'"]
