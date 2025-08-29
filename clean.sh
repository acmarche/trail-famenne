#!/bin/bash
php artisan filament:clear-cached-components
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
rm -fr storage/logs/*.log
