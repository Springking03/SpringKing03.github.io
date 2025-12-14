FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo pdo_mysql zip

RUN a2enmod rewrite \
  && printf '%s\n' \
     '<Directory /var/www/html>' \
     '    AllowOverride All' \
     '</Directory>' \
     > /etc/apache2/conf-available/allowoverride.conf \
  && a2enconf allowoverride

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

COPY . .

COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh \
 && chown -R www-data:www-data /var/www/html

CMD ["/usr/local/bin/start.sh"]
