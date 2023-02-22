FROM php:8.1-fpm

# Set working directory
WORKDIR /srv/www/todo

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    htop \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \ 
    curl \
    libpq-dev \
    libonig-dev libzip-dev mc libxml2-dev libcurl4-openssl-dev pkg-config

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pgsql mysqli pdo_mysql pdo_pgsql iconv mbstring opcache zip exif pcntl xml curl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /srv/www/todo

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

CMD ["php-fpm"]