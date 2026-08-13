FROM composer:lts AS prod-deps
WORKDIR /app
RUN --mount=type=bind,source=./composer.json,target=composer.json \
    --mount=type=bind,source=./composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction --optimize-autoloader

FROM composer:lts AS dev-deps
WORKDIR /app
RUN --mount=type=bind,source=./composer.json,target=composer.json \
    --mount=type=bind,source=./composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-interaction

FROM node:24-alpine AS vite
WORKDIR /app
RUN corepack enable && corepack prepare pnpm@latest --activate
COPY package.json pnpm-lock.yaml ./
RUN --mount=type=cache,target=/root/.local/share/pnpm/store pnpm install
COPY . .
RUN pnpm run build

FROM php:8.5-fpm-alpine AS base
WORKDIR /var/www/html
RUN apk add --no-cache fish pgcli supervisor oxipng su-exec imagemagick imagemagick-dev 
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pgsql pdo_pgsql imagick
RUN printf '#!/bin/sh\nexec env PGPASSWORD="$DB_PASSWORD" pgcli -h db -U "$DB_USER" -d "$DB_NAME"\n' > /usr/local/bin/db && chmod +x /usr/local/bin/db
ARG UID=1000
ARG GID=1000
RUN deluser www-data 2>/dev/null; delgroup www-data 2>/dev/null; \
    addgroup -g $GID www-data && adduser -D -u $UID -G www-data www-data
COPY --chown=www-data:www-data . /var/www/html/

FROM base AS development
COPY config/php-dev.ini "$PHP_INI_DIR/conf.d/php.ini"
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY --from=dev-deps app/vendor/ /var/www/html/vendor
USER www-data

FROM base AS final
COPY --from=vite /app/public/dist /var/www/html/public/dist
COPY config/php-prod.ini "$PHP_INI_DIR/conf.d/php.ini"
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --from=prod-deps app/vendor/ /var/www/html/vendor
USER www-data
