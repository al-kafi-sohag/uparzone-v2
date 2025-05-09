#!/bin/bash
set -e

# Copy .env.example to .env if .env doesn't exist
if [ ! -f /var/www/.env ]; then
    echo "Creating .env file from .env.example"
    cp /var/www/.env.example /var/www/.env
fi

# Update environment variables in .env file
echo "Updating environment variables in .env file"
# APP settings
if [ ! -z "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" /var/www/.env
fi
if [ ! -z "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=$APP_ENV|" /var/www/.env
fi
if [ ! -z "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=$APP_DEBUG|" /var/www/.env
fi
if [ ! -z "$APP_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=$APP_URL|" /var/www/.env
fi

# Database settings
if [ ! -z "$DB_CONNECTION" ]; then
    sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=$DB_CONNECTION|" /var/www/.env
fi
if [ ! -z "$DB_HOST" ]; then
    sed -i "s|^# DB_HOST=.*|DB_HOST=$DB_HOST|" /var/www/.env
    sed -i "s|^DB_HOST=.*|DB_HOST=$DB_HOST|" /var/www/.env
fi
if [ ! -z "$DB_PORT" ]; then
    sed -i "s|^# DB_PORT=.*|DB_PORT=$DB_PORT|" /var/www/.env
    sed -i "s|^DB_PORT=.*|DB_PORT=$DB_PORT|" /var/www/.env
fi
if [ ! -z "$DB_DATABASE" ]; then
    sed -i "s|^# DB_DATABASE=.*|DB_DATABASE=$DB_DATABASE|" /var/www/.env
    sed -i "s|^DB_DATABASE=.*|DB_DATABASE=$DB_DATABASE|" /var/www/.env
fi
if [ ! -z "$DB_USERNAME" ]; then
    sed -i "s|^# DB_USERNAME=.*|DB_USERNAME=$DB_USERNAME|" /var/www/.env
    sed -i "s|^DB_USERNAME=.*|DB_USERNAME=$DB_USERNAME|" /var/www/.env
fi
if [ ! -z "$DB_PASSWORD" ]; then
    sed -i "s|^# DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|" /var/www/.env
    sed -i "s|^DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|" /var/www/.env
fi

# Mail settings
if [ ! -z "$MAIL_MAILER" ]; then
    sed -i "s|^MAIL_MAILER=.*|MAIL_MAILER=$MAIL_MAILER|" /var/www/.env
fi
if [ ! -z "$MAIL_HOST" ]; then
    sed -i "s|^MAIL_HOST=.*|MAIL_HOST=$MAIL_HOST|" /var/www/.env
fi
if [ ! -z "$MAIL_PORT" ]; then
    sed -i "s|^MAIL_PORT=.*|MAIL_PORT=$MAIL_PORT|" /var/www/.env
fi
if [ ! -z "$MAIL_USERNAME" ]; then
    sed -i "s|^MAIL_USERNAME=.*|MAIL_USERNAME=$MAIL_USERNAME|" /var/www/.env
fi
if [ ! -z "$MAIL_PASSWORD" ]; then
    sed -i "s|^MAIL_PASSWORD=.*|MAIL_PASSWORD=$MAIL_PASSWORD|" /var/www/.env
fi
if [ ! -z "$MAIL_FROM_ADDRESS" ]; then
    sed -i "s|^MAIL_FROM_ADDRESS=.*|MAIL_FROM_ADDRESS=$MAIL_FROM_ADDRESS|" /var/www/.env
fi

# SSL Commerz settings
if [ ! -z "$SSLCZ_STORE_ID" ]; then
    sed -i "s|^SSLCZ_STORE_ID=.*|SSLCZ_STORE_ID=$SSLCZ_STORE_ID|" /var/www/.env
fi
if [ ! -z "$SSLCZ_STORE_PASSWORD" ]; then
    sed -i "s|^SSLCZ_STORE_PASSWORD=.*|SSLCZ_STORE_PASSWORD=$SSLCZ_STORE_PASSWORD|" /var/www/.env
fi
if [ ! -z "$SSLCZ_TESTMODE" ]; then
    sed -i "s|^SSLCZ_TESTMODE=.*|SSLCZ_TESTMODE=$SSLCZ_TESTMODE|" /var/www/.env
fi

# Clear cache to pick up env changes
php artisan config:clear

# Generate app key if not set
if grep -q "^APP_KEY=$" /var/www/.env; then
    echo "Generating app key"
    php artisan key:generate
fi

# Create storage symbolic link if it doesn't exist
if [ ! -L /var/www/public/storage ]; then
    echo "Creating storage symbolic link"
    php artisan storage:link
fi

# Migrate database
php artisan migrate --force

# Cache configuration for better performance
echo "Optimizing Laravel"
php artisan optimize:clear

# Start supervisord
echo "Starting supervisord"
exec "$@"
