#!/bin/bash
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/*.conf
php artisan config:cache
php artisan storage:link
apache2-foreground
