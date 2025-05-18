#!/bin/bash

# Очистка кэша Laravel
php artisan optimize:clear

# Запуск всех процессов в фоновом режиме
php artisan serve &
npm run dev &
php artisan queue:listen &
php artisan schedule:work &

# Сохраняем PID последнего процесса
echo $! > .process.pid

# Ждем завершения всех процессов
wait 