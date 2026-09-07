FROM php:8.1-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html

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

RUN printf "display_errors=Off\n\
log_errors=On\n\
error_reporting=E_ALL & ~E_DEPRECATED & ~E_NOTICE\n\
upload_max_filesize=200M\n\
post_max_size=220M\n\
memory_limit=512M\n\
max_execution_time=300\n\
max_input_time=300\n" \
> /usr/local/etc/php/conf.d/app.ini

RUN a2enmod rewrite

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

# Create directories that will later be mounted from VPS
RUN mkdir -p \
    /var/www/html/views/files \
    /var/www/html/views/img \
    /var/www/html/data_backups \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]