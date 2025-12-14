#!/usr/bin/env bash
set -e

: "${PORT:=10000}"

# Apache mặc định nghe port 80 -> đổi sang PORT của Render
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# (tuỳ chọn) set ServerName để hết warning
echo "ServerName localhost" >> /etc/apache2/apache2.conf

exec apache2-foreground
