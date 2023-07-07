# Install composer and npm dependencies
composer i && npm i

# Clear the images folder
rm -rf public/storage
rm -rf storage/app/public/*

# Create the symbolic link
php artisan storage:link

# Clear and seed the database
php artisan migrate:fresh --seed

# Build the frontend
npm run build
