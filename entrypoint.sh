#!/bin/sh

php artisan migrate --force
php artisan migrate:status
php artisan optimize
php artisan serve --host=0.0.0.0 --port=80
