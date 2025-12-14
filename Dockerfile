FROM php:8.2-apache

# Install tools needed by composer + zip
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev \
  && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

# Enable rewrite + AllowOverride for .htaccess (no sed hacks)
RUN a2enmod rewrite \
  && printf '%s\n' \
     '<Directory /var/www/html>' \
     '    AllowOverride All' \
     '</Directory>' \
     > /etc/apache2/conf-available/allowoverride.conf \
  && a2enconf allowoverride

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP deps (creates vendor/)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# Copy source
COPY . .

# Startup script to bind Apache to Render's $PORT
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh \
 && chown -R www-data:www-data /var/www/html

CMD ["/usr/local/bin/start.sh"]
