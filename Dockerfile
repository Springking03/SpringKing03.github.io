# Multi-stage build: cài vendor bằng Composer rồi copy sang image Apache+PHP
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

FROM php:8.2-apache

# PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache rewrite + AllowOverride (để .htaccess có hiệu lực)
RUN a2enmod rewrite \
 && printf '%s\n' \
    '<Directory /var/www/html>' \
    '    AllowOverride All' \
    '</Directory>' \
    > /etc/apache2/conf-available/allowoverride.conf \
 && a2enconf allowoverride \
 && echo 'ServerName localhost' > /etc/apache2/conf-available/servername.conf \
 && a2enconf servername

WORKDIR /var/www/html

# Copy source
COPY . .

# Copy vendor từ stage composer
COPY --from=vendor /app/vendor ./vendor

RUN chown -R www-data:www-data /var/www/html

# Render yêu cầu service lắng nghe trên $PORT.
# start.sh sẽ map Apache sang đúng port rồi chạy apache2-foreground.
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
