#!/usr/bin/env bash
set -e

: "${PORT:=10000}"

# Make Apache listen on Render's PORT
sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Optional: suppress ServerName warning
grep -q "^ServerName" /etc/apache2/apache2.conf || echo "ServerName localhost" >> /etc/apache2/apache2.conf

exec apache2-foreground
