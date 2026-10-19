#!/bin/sh
set -e

cd /var/www/html

if [ -z "${APP_KEY:-}" ]; then
    key_file=/var/www/app-key/APP_KEY

    if [ -s "$key_file" ]; then
        APP_KEY=$(cat "$key_file")
    else
        echo "[init] APP_KEY no está configurada; generando una clave de aplicación..."
        APP_KEY=$(php artisan key:generate --show --no-interaction)
        printf '%s\n' "$APP_KEY" > "$key_file"
    fi

    export APP_KEY
fi

php docker/init-db.php

exec "$@"
