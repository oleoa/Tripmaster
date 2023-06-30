git pull
cp .env.example .env
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS tripmaster;"
composer i && npm i
#rm -rf public/storage
#rm -rf storage/app/public/*
php artisan storage:link
php artisan migrate:fresh --seed

folder=$(git rev-parse --show-toplevel)

exec php "$folder"/artisan serve --host=0.0.0.0 --port=80 & exec npm run build &
trap stop_commands INT
wait

