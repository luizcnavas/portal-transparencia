# Multi-stage build for Laravel (PHP 8.2 + Apache) with Vite assets

# --- Stage 1: Build frontend assets with Node ---
FROM node:20-alpine AS nodebuilder
WORKDIR /app

# Install deps with cache
COPY package*.json ./
RUN npm ci

# Copy the rest of the project needed for the asset build (Tailwind/Vite configs, resources, etc.)
COPY . .

# Build assets
RUN npm run build

# --- Stage 2: PHP + Apache runtime ---
FROM php:8.2-apache

# System dependencies
RUN apt-get update && apt-get install -y \
	git \
	zip \
	unzip \
	pkg-config \
	libzip-dev \
	libpng-dev \
	libjpeg62-turbo-dev \
	libfreetype6-dev \
	libonig-dev \
	sqlite3 \
	libsqlite3-dev \
	&& rm -rf /var/lib/apt/lists/*

# PHP extensions commonly used by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) \
	pdo \
	pdo_mysql \
	pdo_sqlite \
	mbstring \
	exif \
	bcmath \
	zip \
	gd \
	opcache

# Enable Apache modules
RUN a2enmod rewrite headers && \
	echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && \
	a2enconf servername

# Set document root to public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's#DocumentRoot /var/www/html#DocumentRoot ${APACHE_DOCUMENT_ROOT}#g' /etc/apache2/sites-available/000-default.conf && \
	sed -ri 's#<Directory /var/www/>#<Directory ${APACHE_DOCUMENT_ROOT}>#g' /etc/apache2/apache2.conf && \
	sed -ri 's#AllowOverride None#AllowOverride All#g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Composer files first and install dependencies for better caching
COPY composer.json composer.lock ./
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# Copy application source
COPY . .

# Copy built assets from node stage
COPY --from=nodebuilder /app/public/build ./public/build

# Ensure storage and cache directories are writable
RUN chown -R www-data:www-data storage bootstrap/cache && \
	chmod -R 775 storage bootstrap/cache

# Entrypoint to run optimizations and migrations, then start Apache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
