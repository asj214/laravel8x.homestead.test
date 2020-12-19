git checkout composer.lock
git pull
composer install --optimize-autoloader --no-dev
php artisan migrate