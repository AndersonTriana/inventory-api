FROM php:8.3-apache

RUN apt-get update

# 1. development packages
RUN apt-get install -y \
        libonig-dev \
        git \
        zip \
        curl \
        sudo \
        unzip \
        libicu-dev \
        libbz2-dev \
        libpng-dev \
        libjpeg-dev \
        libmcrypt-dev \
        libreadline-dev \
        libfreetype6-dev \
        g++ \
        libzip-dev \
        libpq-dev \
        nano

# 2. apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# 4. start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# 4.1 instala extensiones de PHP
RUN docker-php-ext-install \
        bz2 \
        intl \
        iconv \
        bcmath \
        opcache \
        calendar \
        mbstring \
        pdo_pgsql \
        zip

# 4.2 instala GD (php-gd)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# 5. composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. código del proyecto
COPY . /var/www/html/
WORKDIR /var/www/html/

# 7. instalación de dependencias
RUN composer update --no-interaction && \
    composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# 8 ajustar permisos requeridos por Laravel
RUN mkdir -p /var/www/html/storage/logs && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# 9 redirigir logs de Laravel a stdout
RUN ln -sf /dev/stdout /var/www/html/storage/logs/laravel.log

# 10. generación de clave Laravel
RUN php artisan key:generate

# 11. migración de base de datos
# RUN php artisan migrate --force # Commented out: Run migrations after the container starts