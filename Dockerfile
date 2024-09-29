# Use the official PHP image as the base image
FROM php:8.3-alpine AS base

RUN apk update && \
    apk add --no-cache libsodium-dev zlib-dev libpng-dev icu-dev libxml2-dev libxslt-dev libzip-dev curl libpq-dev nodejs npm linux-headers && \
    docker-php-ext-install bcmath sodium gd intl soap xsl zip pdo_pgsql sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    rm -rf /var/cache/apk/*

FROM node:22.8-alpine AS nodeenv
RUN corepack enable
WORKDIR /app
COPY ./.yarnrc.yml .
COPY package.json .
ENV NODE_ENV="production"
RUN yarn workspaces focus --production
COPY . .
RUN yarn build

FROM base AS filesystem
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

FROM filesystem AS laravel
COPY entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Set the entrypoint
ENTRYPOINT ["entrypoint"]
CMD ["./entrypoint.sh"]
