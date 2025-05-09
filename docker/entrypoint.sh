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
if [ ! -z "$APP_NAME" ]; then
    sed -i "s|^APP_NAME=.*|APP_NAME=$APP_NAME|" /var/www/.env
fi
if [ ! -z "$APP_ENV" ]; then
    sed -i "s|^APP_ENV=.*|APP_ENV=$APP_ENV|" /var/www/.env
fi
if [ ! -z "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" /var/www/.env
fi
if [ ! -z "$APP_DEBUG" ]; then
    sed -i "s|^APP_DEBUG=.*|APP_DEBUG=$APP_DEBUG|" /var/www/.env
fi
if [ ! -z "$APP_LOCALE" ]; then
    sed -i "s|^APP_LOCALE=.*|APP_LOCALE=$APP_LOCALE|" /var/www/.env
fi
if [ ! -z "$APP_FALLBACK_LOCALE" ]; then
    sed -i "s|^APP_FALLBACK_LOCALE=.*|APP_FALLBACK_LOCALE=$APP_FALLBACK_LOCALE|" /var/www/.env
fi
if [ ! -z "$APP_FAKER_LOCALE" ]; then
    sed -i "s|^APP_FAKER_LOCALE=.*|APP_FAKER_LOCALE=$APP_FAKER_LOCALE|" /var/www/.env
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

# Session settings
if [ ! -z "$SESSION_DRIVER" ]; then
    sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=$SESSION_DRIVER|" /var/www/.env
fi
if [ ! -z "$SESSION_LIFETIME" ]; then
    sed -i "s|^SESSION_LIFETIME=.*|SESSION_LIFETIME=$SESSION_LIFETIME|" /var/www/.env
fi
if [ ! -z "$SESSION_ENCRYPT" ]; then
    sed -i "s|^SESSION_ENCRYPT=.*|SESSION_ENCRYPT=$SESSION_ENCRYPT|" /var/www/.env
fi
if [ ! -z "$SESSION_PATH" ]; then
    sed -i "s|^SESSION_PATH=.*|SESSION_PATH=$SESSION_PATH|" /var/www/.env
fi
if [ ! -z "$SESSION_DOMAIN" ]; then
    sed -i "s|^SESSION_DOMAIN=.*|SESSION_DOMAIN=$SESSION_DOMAIN|" /var/www/.env
fi

# Queue settings
if [ ! -z "$QUEUE_CONNECTION" ]; then
    sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=$QUEUE_CONNECTION|" /var/www/.env
fi

# Cache settings
if [ ! -z "$CACHE_STORE" ]; then
    sed -i "s|^CACHE_STORE=.*|CACHE_STORE=$CACHE_STORE|" /var/www/.env
fi
if [ ! -z "$CACHE_PREFIX" ]; then
    sed -i "s|^CACHE_PREFIX=.*|CACHE_PREFIX=$CACHE_PREFIX|" /var/www/.env
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

# Google Auth settings
if [ ! -z "$GOOGLE_CLIENT_ID" ]; then
    sed -i "s|^GOOGLE_CLIENT_ID=.*|GOOGLE_CLIENT_ID=$GOOGLE_CLIENT_ID|" /var/www/.env
fi
if [ ! -z "$GOOGLE_CLIENT_SECRET" ]; then
    sed -i "s|^GOOGLE_CLIENT_SECRET=.*|GOOGLE_CLIENT_SECRET=$GOOGLE_CLIENT_SECRET|" /var/www/.env
fi
if [ ! -z "$GOOGLE_REDIRECT_URI" ]; then
    sed -i "s|^GOOGLE_REDIRECT_URI=.*|GOOGLE_REDIRECT_URI=$GOOGLE_REDIRECT_URI|" /var/www/.env
fi

# Heartbeat settings
if [ ! -z "$HEARTBEAT_INTERVAL" ]; then
    sed -i "s|^HEARTBEAT_INTERVAL=.*|HEARTBEAT_INTERVAL=$HEARTBEAT_INTERVAL|" /var/www/.env
fi
if [ ! -z "$MIN_FLAGGING_AMOUNT" ]; then
    sed -i "s|^MIN_FLAGGING_AMOUNT=.*|MIN_FLAGGING_AMOUNT=$MIN_FLAGGING_AMOUNT|" /var/www/.env
fi
if [ ! -z "$PREMIUM_PRICE" ]; then
    sed -i "s|^PREMIUM_PRICE=.*|PREMIUM_PRICE=$PREMIUM_PRICE|" /var/www/.env
fi

# Localhost settings
if [ ! -z "$IS_LOCALHOST" ]; then
    sed -i "s|^IS_LOCALHOST=.*|IS_LOCALHOST=$IS_LOCALHOST|" /var/www/.env
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
