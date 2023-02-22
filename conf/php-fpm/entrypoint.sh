cd /srv/www/todo
php artisan migrate
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=GroupSeeder
php artisan db:seed --class=StatusesSeeder