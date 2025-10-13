#!/usr/bin/env bash
set -euo pipefail

# If APP_KEY is missing, try to generate one (first run)
if [ -z "${APP_KEY:-}" ] || [ "$APP_KEY" = "" ]; then
	php artisan key:generate --force || true
fi

# Optimize caches (config, routes, views)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Ensure storage symlink exists
php artisan storage:link || true

# Run database migrations if database is reachable
php artisan migrate --force || true

# Start Apache in foreground
apache2-foreground
