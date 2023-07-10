# Get the current code in github
git pull

# Copy the .env.example to .env for the default configs
cp .env.example .env

# Install the composer dependencies
composer i && npm i

# Clear the images folder
rm -rf public/storage
rm -rf storage/app/public/*

# Create the symbolic link
php artisan storage:link

# Clear and seed the database
php artisan migrate:fresh --seed
