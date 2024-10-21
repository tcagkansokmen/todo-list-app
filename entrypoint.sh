#!/bin/bash

php artisan migrate --seed

php artisan migrate --database=mysql --path=database/migrations --database=laravel_test

php-fpm
