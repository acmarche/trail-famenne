#!/bin/bash
php artisan filament:clear-cached-components
php artisan cache:clear
rm -fr storage/logs/*.log
chow www-data:www-data bootstrap/cache/ -R storage -R
