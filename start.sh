#!/bin/bash
a2dismod mpm_event mpm_worker 2>/dev/null
a2enmod mpm_prefork
echo "ServerName localhost" >> /etc/apache2/apache2.conf
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/*.conf

# Show what env vars are available
echo "APP_KEY: $APP_KEY"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_HOST: $DB_HOST"

php artisan config:clear
php artisan key:generate --force
php artisan storage:link --force
php artisan migrate --force

apache2-foreground
