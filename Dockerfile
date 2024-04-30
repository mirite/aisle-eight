# Use the official PHP image as the base image
FROM php:8.3-cli as base

RUN apt-get update && \
    apt-get install -y libsodium-dev zlib1g-dev libpng-dev libicu-dev libxml2-dev libxslt-dev libzip-dev apt-transport-https curl software-properties-common libpq-dev
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install nodejs

# Install required PHP extensions
RUN docker-php-ext-install bcmath sodium gd intl soap xsl zip sockets pdo_pgsql
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#RUN addgroup --system --gid 1001 appenv
#RUN adduser --system --uid 1001 --home /app aisleeight
#RUN chown -R aisleeight:appenv /app
RUN corepack enable
#USER aisleeight

FROM base AS nodeenv
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
