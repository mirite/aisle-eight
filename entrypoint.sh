#!/bin/bash

php artisan migrate:install
php artisan serve --host=0.0.0.0 --port=80
