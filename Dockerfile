FROM php:8.2-fpm

# Install Dockerize
ENV DOCKERIZE_VERSION 0.6.1

RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.7.1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

# Install nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_21.x | bash - &&\
apt-get install -y nodejs

# Install Dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        unzip \
        zip \
        libicu-dev \
    && apt-get clean \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
        intl \
    && rm -rf /var/lib/apt/lists/*;

WORKDIR /usr/src/app

RUN chown -R www-data:www-data .
