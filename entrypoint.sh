#!/bin/sh

php artisan migrate --force
php artisan migrate:status
php artisan optimize
php artisan octane:frankenphp --host=0.0.0.0 --https
