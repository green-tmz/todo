# todo

Тестовое задание

Стек:
  - nginx
  - php 8.1
  - postgreSQL
  
Запуск проекта
  1. docker-compose up -d
  2. cd /app
  3. php artisan migrate
  4. php artisan db:seed --class=UserSeeder
  5. php artisan db:seed --class=GroupSeeder
  6. php artisan db:seed --class=StatusesSeeder
  
Логин/пароль:
admin@todo.com
12345
