#!/bin/sh

if [ "$1" = "--server" ]; then

  composer i && npm i
  php artisan storage:link
  php artisan migrate:fresh --seed
  exec php "$folder"/artisan serve --host=0.0.0.0 --port=80 & exec npm run build &
  trap stop_commands INT
  exit

fi

if [ "$1" = "--init" ]; then
  git pull
  cp .env.example .env
  mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS tripmaster;"
  composer i && npm i
  #rm -rf public/storage
  #rm -rf storage/app/public/*
  php artisan storage:link
  php artisan migrate:fresh --seed
fi

if [ "$1" = "--db" ]; then
    git pull
    php artisan migrate:fresh --seed
fi

stop_commands() {
  kill %1 %2
}

folder=$(git rev-parse --show-toplevel)

exec php "$folder"/artisan serve --host=0.0.0.0 & exec npm run dev &
trap stop_commands INT
wait
