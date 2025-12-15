FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update \
    && apt-get install -y git curl libpq-dev zip unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy existing application (if present) and install dependencies
COPY . /var/www/html
RUN if [ -f composer.json ]; then composer install --no-interaction --prefer-dist --optimize-autoloader || true; fi

# Expose port for artisan serve
EXPOSE 8000

CMD ["php-fpm"]
