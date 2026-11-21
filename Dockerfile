# syntax=docker/dockerfile:1
#
# Production image for testing-soft (Laravel 13, PHP 8.4).
#
# Targets:
#   app  - PHP-FPM with the application code and Composer dependencies
#   web  - Nginx serving static files and proxying everything else to `app`
#
# Build both through docker compose (see docker-compose.yml and DEPLOY.md).

############################
# 1. Front-end assets (Vite)
############################
FROM node:22-bookworm-slim AS assets
WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci

COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
RUN npm run build


############################
# 2. PHP base
############################
FROM php:8.4-fpm-bookworm AS base

COPY --from=mlocati/php-extension-installer:2 /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql bcmath gd intl zip exif opcache

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/app.ini "$PHP_INI_DIR/conf.d/zz-app.ini"


############################
# 3. Application (PHP-FPM)
############################
FROM base AS app
WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies first so this layer is cached between code changes.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist \
        --no-scripts --no-autoloader

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev --no-interaction \
    && mkdir -p storage/app/public storage/app/private \
        storage/framework/cache/data storage/framework/sessions \
        storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint && chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]
CMD ["php-fpm"]


############################
# 4. Web server (Nginx)
############################
FROM nginx:1.27-alpine AS web

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Only static files are copied here; PHP source, .env and vendor never reach Nginx.
COPY --from=app /var/www/html/public /var/www/html/public
COPY theme  /var/www/html/theme
COPY images /var/www/html/images
COPY sound  /var/www/html/sound
COPY favicon.ico robots.txt /var/www/html/
