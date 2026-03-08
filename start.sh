#!/bin/bash
a2dismod mpm_event mpm_worker 2>/dev/null
a2enmod mpm_prefork
sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/*.conf
php artisan config:clear
php artisan storage:link --force
apache2-foreground

