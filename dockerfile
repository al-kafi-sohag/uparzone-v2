# Use official PHP 8.3 FPM image as base
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
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
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install gd exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install svgo
RUN npm install -g svgo

# Create non-root user and group
RUN groupadd -g 1001 appgroup && \
    useradd -u 1001 -g appgroup -s /bin/bash -m appuser

# Set working directory
WORKDIR /var/www

# Copy Laravel project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Run Laravel setup commands
RUN php artisan migrate --force && \
    php artisan optimize:clear && \
    php artisan config:cache && \
    php artisan view:cache && \
    php artisan queue:restart

# Build frontend (only if applicable)
RUN npm install && npm run build

# Set permissions for non-root user
RUN chown -R appuser:appgroup /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy NGINX config
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/default.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Copy Supervisor config
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose HTTP port
EXPOSE 80

# Switch to non-root user
USER appuser

# Start all services
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
