FROM php:8.2-apache

# Cài công cụ cần cho composer + unzip
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev \
  && rm -rf /var/lib/apt/lists/*

# PHP extensions cần cho dự án
RUN docker-php-ext-install mysqli pdo pdo_mysql zip pcntl

# Bật rewrite + cho phép .htaccess
RUN a2enmod rewrite \
  && sed -i '/<Directory \\/var\\/www\\/>/,/<\\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer trước để tận dụng cache
COPY composer.json composer.lock ./

# Cài vendor (QUAN TRỌNG: tạo vendor/autoload.php)
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# Copy toàn bộ source
COPY . .

# Quyền thư mục
RUN chown -R www-data:www-data /var/www/html

# Apache chạy mặc định
CMD ["apache2-foreground"]
