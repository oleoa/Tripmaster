#!/bin/sh

folder=$(git rev-parse --show-toplevel)

exec php "$folder"/artisan serve --host=0.0.0.0 --port=80 & exec npm run build &
trap stop_commands INT
wait
