#!/bin/bash

# PHP-FPMをバックグラウンドで起動
php-fpm -D

# Nginxをフォアグラウンドで起動
nginx -g "daemon off;"