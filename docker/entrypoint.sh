#!/usr/bin/env bash
set -euo pipefail

# Ensure .env exists (copy from example if missing)
if [ ! -f ".env" ] && [ -f ".env.example" ]; then
	cp .env.example .env || true
fi

# If APP_KEY is missing, try to generate one (first run)
if [ -z "${APP_KEY:-}" ] || [ "$APP_KEY" = "" ]; then
	php artisan key:generate --force || true
fi

# If using SQLite, ensure database file exists
if [ "${DB_CONNECTION:-}" = "sqlite" ]; then
	DB_FILE_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
	mkdir -p "$(dirname "$DB_FILE_PATH")" || true
	if [ ! -f "$DB_FILE_PATH" ]; then
		touch "$DB_FILE_PATH" || true
		chown www-data:www-data "$DB_FILE_PATH" || true
		chmod 664 "$DB_FILE_PATH" || true
	fi
fi

# If a custom PORT is provided by the platform, reconfigure Apache to listen on it
if [ -n "${PORT:-}" ]; then
	# Update ports.conf and default vhost to use $PORT
	sed -ri "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf || true
	sed -ri "s#<VirtualHost \*:.*>#<VirtualHost *:${PORT}>#" /etc/apache2/sites-available/000-default.conf || true
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
