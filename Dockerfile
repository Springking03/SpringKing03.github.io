FROM php:8.2-apache

# Tools cho composer + unzip
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev \
  && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

# Bật rewrite + cho phép .htaccess (KHÔNG dùng sed)
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

# Cài vendor
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# Copy source
COPY . .

RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]
