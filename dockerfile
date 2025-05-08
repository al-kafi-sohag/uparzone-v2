# Use the official PHP 8.3 FPM image as base
FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    cron \
    supervisor \
    git \
    unzip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    libavif-bin \
    nodejs \
    npm \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install svgo globally via npm
RUN npm install -g svgo

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project files (assumes Dockerfile is in root of Laravel project)
COPY . .

# Set permissions (adjust as needed)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Copy supervisor configuration
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# # # Copy crontab file
# # COPY ./docker/laravel.cron /etc/cron.d/laravel

# # Give execution rights to the cron job
# RUN chmod 0644 /etc/cron.d/laravel && \
#     crontab /etc/cron.d/laravel

# Start PHP-FPM, Supervisor, and Cron in the same container
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
