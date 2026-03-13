#!/bin/bash
set -e

echo "Deployment started..."

# Enter maintenance mode
(php artisan down) || true

# Update codebase
git pull origin main

# Install dependencies based on lock file
composer install --no-dev --optimize-autoloader

# Migrate database
php artisan migrate --force

# Clear and set caches
php artisan optimize
php artisan view:cache
php artisan event:cache

# Install/Build frontend assets
npm install
npm run build

# Exit maintenance mode
php artisan up

echo "Deployment finished successfully!"
