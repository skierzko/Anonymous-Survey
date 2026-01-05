FROM php:8.4.5-fpm-bookworm

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN set -eux \
\
    # Persistent dependencies
        && apt-get update \
        && apt-get install -y --no-install-recommends \
            libfreetype6 \
            libjpeg62-turbo \
            ^libzip[0-9]$ \
            ^libpng[0-9]+-[0-9]+$ \
            ^libicu[0-9]+$ \
\
    # Build dependencies
        && savedAptMark="$(apt-mark showmanual)" \
        && apt-get install -y --no-install-recommends \
            $PHPIZE_DEPS \
            git \
            binutils \
            libzip-dev \
            libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng-dev \
            libicu-dev \
\
        && apt-get install -y \
            git \
            unzip \
            libpq-dev \
            libzip-dev \
            libicu-dev \
            libonig-dev \
        && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl zip opcache \
\
    ## PHP extensions
    # Install opcache
        && docker-php-ext-enable opcache \
\
    # Install zip
        && docker-php-ext-configure zip --with-zip \
        && docker-php-ext-install -j$(nproc) zip \
\
    # Install gd
        && docker-php-ext-configure gd --with-jpeg --with-freetype \
        && docker-php-ext-install -j$(nproc) gd \
\
    # Install pdo_mysql
        && docker-php-ext-install -j$(nproc) pdo_mysql \
\
    # Install pcntl
        && docker-php-ext-install -j$(nproc) pcntl \
\
    # Install intl
        && docker-php-ext-install -j$(nproc) intl \
\
    # Install redis
        && pecl install -o redis \
        && docker-php-ext-enable redis \
\
    # Install xdebug
        && pecl install xdebug-3.4.1 \
        && docker-php-ext-enable xdebug \
\
    # Php config
        && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
\
    # Shrink binaries
        && (find /usr/local/bin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
        && (find /usr/local/lib -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
        && (find /usr/local/sbin -type f -print0 | xargs -n1 -0 strip --strip-all -p 2>/dev/null || true) \
\
    # Clean up
        && apt-mark auto '.*' > /dev/null \
        && apt-mark manual $savedAptMark \
        && ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
            | awk '/=>/ { print $3 }' \
            | sort -u \
            | xargs -r dpkg-query -S \
            | cut -d: -f1 \
            | sort -u \
            | xargs -rt apt-mark manual \
        && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy configuration files
COPY docker/conf/php/php.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/conf/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
