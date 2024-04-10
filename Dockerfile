# Use the official PHP image as the base image
FROM php:8.3-apache as base

RUN apt-get update && \
    apt-get install -y libsodium-dev zlib1g-dev libpng-dev libicu-dev libxml2-dev libxslt-dev libzip-dev

# Install required PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath sodium gd intl soap xsl zip sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

FROM node:20.12-alpine AS nodeenv
COPY package.json .
COPY yarn.lock .
COPY .yarn .yarn
RUN corepack enable
RUN yarn install
COPY . .
RUN yarn build

FROM base as files
# Set the working directory to the Magento root directory
WORKDIR /var/www/html

# Copy the Laravel files to the container
COPY . .

FROM files as filesystem
WORKDIR /var/www/html
COPY --from=nodeenv dist dist
# Install laravel dependencies using Composer
RUN composer update --no-dev --prefer-source


FROM filesystem as laravel


# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]