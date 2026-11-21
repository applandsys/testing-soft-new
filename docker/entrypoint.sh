#!/bin/sh
set -e

cd /var/www/html

# The storage volume may be empty on first start; recreate Laravel's layout.
mkdir -p storage/app/public storage/app/private \
    storage/framework/cache/data storage/framework/sessions \
    storage/framework/views storage/logs bootstrap/cache

if [ "$1" = "php-fpm" ]; then
    if [ -z "$APP_KEY" ]; then
        echo "ERROR: APP_KEY is not set. Add it to .env (see DEPLOY.md)." >&2
        exit 1
    fi

    if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
        php artisan migrate --force
    fi

    # Cache config, routes, views and events for production.
    php artisan optimize
fi

chown -R www-data:www-data storage bootstrap/cache

exec "$@"
