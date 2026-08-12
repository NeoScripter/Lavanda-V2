FROM php:8.5-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache fish
RUN apk add --no-cache pgcli
# extensions first — cached layer, rarely changes
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd pgsql pdo_pgsql

RUN printf '#!/bin/sh\nexec env PGPASSWORD="$DB_PASSWORD" pgcli -h db -U "$DB_USER" -d "$DB_NAME"\n' > /usr/local/bin/db \
    && chmod +x /usr/local/bin/db

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# node + pnpm
RUN apk add --no-cache nodejs npm \
    && npm install -g pnpm@10

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader

COPY package.json pnpm-lock.yaml ./
RUN --mount=type=cache,target=/root/.local/share/pnpm/store pnpm install

COPY . .

ARG UID=1000
ARG GID=1001
RUN deluser www-data 2>/dev/null; \
    delgroup www-data 2>/dev/null; \
    addgroup -g ${GID} www-data && \
    adduser -D -H -u ${UID} -G www-data www-data

CMD ["sh", "-c", "pnpm run build --watch & exec php-fpm"]
