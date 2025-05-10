#!/bin/bash

# Запуск queue worker в фоновом режиме
php artisan queue:work > storage/logs/queue.log 2>&1 &
QUEUE_PID=$!

# Запуск scheduler
php artisan schedule:work

# При завершении scheduler'а, завершаем queue worker
kill $QUEUE_PID 