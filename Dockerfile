# Use the official PHP image as the base image
FROM php:8.3-alpine as base

RUN apk update && \
    apk add --no-cache libsodium-dev zlib-dev libpng-dev icu-dev libxml2-dev libxslt-dev libzip-dev curl libpq-dev nodejs npm linux-headers && \
    docker-php-ext-install bcmath sodium gd intl soap xsl zip pdo_pgsql sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    rm -rf /var/cache/apk/*

FROM node:20.12-alpine AS nodeenv
RUN corepack enable
WORKDIR /app
COPY ./.yarn/releases ./.yarn/releases
COPY ./.yarnrc.yml .
COPY yarn.lock .
COPY package.json .
RUN yarn install
COPY . .
RUN yarn build

FROM base as filesystem
WORKDIR /app
COPY --from=nodeenv /app .
ARG DB_CONNECTION
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD
ENV DB_CONNECTION=$DB_CONNECTION
ENV DB_HOST=$DB_HOST
ENV DB_PORT=$DB_PORT
ENV DB_DATABASE=$DB_DATABASE
ENV DB_USERNAME=$DB_USERNAME
ENV DB_PASSWORD=$DB_PASSWORD

RUN composer install --no-dev --prefer-source
RUN composer dump-autoload

FROM filesystem as laravel
COPY entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Set the entrypoint
ENTRYPOINT ["entrypoint"]
CMD ./entrypoint.sh
