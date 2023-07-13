#!/bin/bash

# Get the current code in github
git pull

# Copy the .env.example to .env for the default configs
cp .env.example .env

# Generate the key
php artisan key:generate

# Asks for the name, email and password for the admin user
echo "What is the name of the admin user?"
read admin_name
admin_name=${admin_name:-Admin}
echo "Admin name: $admin_name"
sed -i "s/^ADMIN_NAME=.*/ADMIN_NAME=$admin_name/" .env

echo "What is the email of the admin user?"
read admin_email
admin_email=${admin_email:-admin@localhost}
echo "Admin email: $admin_email"
sed -i "s/^ADMIN_EMAIL=.*/ADMIN_EMAIL=$admin_email/" .env

echo "What is the password of the admin user?"
read admin_password
admin_password=${admin_password:-admin123}
echo "Admin password: $admin_password"
sed -i "s/^ADMIN_PASSWORD=.*/ADMIN_PASSWORD=$admin_password/" .env

# Asks if wants the DEBUG mode on or off
echo "Do you want the DEBUG mode on? [y/N]"
read debug_mode
debug_mode=${debug_mode:-N}
if [[ $debug_mode =~ ^[Yy]$ ]]; then
  echo "Debug mode"
else
  echo "No debug mode"
fi

# Check the user's choice
if [[ $debug_mode =~ ^[Yy]$ ]]; then
  sed -i "s/^APP_DEBUG=.*/APP_DEBUG=true/" .env
elif [[ $debug_mode =~ ^[Nn]$ ]]; then
  sed -i "s/^APP_DEBUG=.*/APP_DEBUG=false/" .env
else
  sed -i "s/^APP_DEBUG=.*/APP_DEBUG=false/" .env
fi

# Install the composer dependencies
composer i && npm i

# Clear the images folder
rm -rf public/storage
rm -rf storage/app/public/*

# Create the symbolic link
php artisan storage:link

# Clear and seed the database
php artisan migrate:fresh --seed

# Asks if wants local or production environment
echo "Do you want the production environment? [Y/n]"
read environment
environment=${environment:-Y}
if [[ $environment =~ ^[Yy]$ ]]; then
  echo "Production environment"
else
  echo "Local environment"
fi

# Get the current folder
folder=$(git rev-parse --show-toplevel)

# Asks the user the port to run the application
echo "What port do you want to run the application? [8000/8001/80]"
read port
port=${port:-8000}

# Define the list of values
valid_values=("8000" "8001" "80")

# Check if the user's answer is in the list
if [[ " ${valid_values[@]} " =~ " ${port} " ]]; then
  echo "Starting the application on port $port..."
else
  echo "Starting the application on port 8000..."
  port="8000"
fi

# Check the user's choice
if [[ $environment =~ ^[Nn]$ ]]; then
  sed -i "s/^APP_ENV=.*/APP_ENV=local/" .env
  exec php "$folder"/artisan serve --host=0.0.0.0 --port=$port & npm run dev &
else
  sed -i "s/^APP_ENV=.*/APP_ENV=production/" .env
  npm run build
  exec php "$folder"/artisan serve --host=0.0.0.0 --port=$port &
fi

trap stop_commands INT
wait
