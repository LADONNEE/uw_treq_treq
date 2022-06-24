FROM php:8.0-apache

USER root

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y  \
    nodejs \
    npm \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    unzip \
    libfreetype6-dev \
    libjpeg-dev \
    libwebp-dev \
    --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-enable opcache \    
    && apt-get autoclean -y \
    && rm -rf /var/lib/apt/lists/* 

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Update apache conf to point to application public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/public
#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Update uploads config
#RUN echo "file_uploads = On\n" \
#         "memory_limit = 1024M\n" \
#         "upload_max_filesize = 512M\n" \
#         "post_max_size = 512M\n" \
#         "max_execution_time = 1200\n" \
#         > /usr/local/etc/php/conf.d/uploads.ini

# Enable headers module
#RUN a2enmod rewrite headers 
RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite