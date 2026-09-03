FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html

# System dependencies + common PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        gd \
    && rm -rf /var/lib/apt/lists/*


RUN pecl install dbase-7.1.1 \
    && docker-php-ext-enable dbase

    # PHP error configuration for legacy application/TCPDF
RUN printf "display_errors=Off\n\
log_errors=On\n\
error_reporting=E_ALL & ~E_DEPRECATED & ~E_NOTICE\n" \
> /usr/local/etc/php/conf.d/app.ini



# Enable Apache rewrite for MVC routing / .htaccess
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN printf '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n' > /etc/apache2/conf-available/app.conf \
    && a2enconf app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./


RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]