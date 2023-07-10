folder=$(git rev-parse --show-toplevel)
exec php "$folder"/artisan serve --host=0.0.0.0 & exec npm run dev &
trap stop_commands INT
wait
