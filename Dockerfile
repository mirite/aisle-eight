# Use the official PHP image as the base image
FROM dunglas/frankenphp AS base

RUN apt update && \
    apt install -y libsodium-dev libpng-dev libxml2-dev libxslt-dev libzip-dev libpq-dev && \
    docker-php-ext-install bcmath sodium gd intl soap xsl zip pdo_pgsql sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    rm -rf /var/cache/apt/*

FROM base AS filesystem
WORKDIR /app
COPY . .
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
