# Use the official PHP image as the base image
FROM php:8.3-cli as base

RUN apt-get update && \
    apt-get install -y libsodium-dev zlib1g-dev libpng-dev libicu-dev libxml2-dev libxslt-dev libzip-dev

# Install required PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath sodium gd intl soap xsl zip sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

FROM node:20.12-alpine AS nodeenv
WORKDIR /app
RUN corepack enable
COPY ./.yarn/releases ./.yarn/releases
COPY ./.yarnrc.yml .
COPY yarn.lock .
COPY package.json .
RUN yarn install
COPY . .
RUN yarn build

FROM base as filesystem

WORKDIR app

COPY --from=nodeenv /app .
# Install laravel dependencies using Composer
RUN composer update --no-dev --prefer-source
RUN composer dump-autoload
FROM filesystem as laravel
CMD php artisan serve --host=0.0.0.0 --port=80

