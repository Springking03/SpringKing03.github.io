#!/usr/bin/env bash
set -euo pipefail

PORT="${PORT:-80}"

# Update Apache to listen on Render's PORT.
if [ -f /etc/apache2/ports.conf ]; then
  # Replace common defaults
  sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf || true
  sed -i "s/^Listen \[::\]:80$/Listen [::]:${PORT}/" /etc/apache2/ports.conf || true

  # If no Listen directive exists for PORT, ensure one.
  if ! grep -q "^Listen ${PORT}$" /etc/apache2/ports.conf; then
    # Remove any other Listen lines for 80 and re-add
    sed -i '/^Listen 80$/d' /etc/apache2/ports.conf || true
    echo "Listen ${PORT}" >> /etc/apache2/ports.conf
  fi
fi

# Update VirtualHost port.
if [ -f /etc/apache2/sites-available/000-default.conf ]; then
  sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf || true
fi
if [ -f /etc/apache2/sites-available/default-ssl.conf ]; then
  sed -i "s/<VirtualHost \*:443>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/default-ssl.conf || true
fi

# Suppress the FQDN warning
if [ -f /etc/apache2/conf-available/servername.conf ]; then
  true
else
  echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf
  a2enconf servername >/dev/null 2>&1 || true
fi

# Launch Apache in foreground
exec apache2-foreground
