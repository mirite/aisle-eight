#!/bin/bash

php artisan migrate
php artisan migrate:status
php artisan serve --host=0.0.0.0 --port=80
