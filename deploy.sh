#!/bin/bash
# Script de despliegue para producción (DigitalOcean Droplet)
#
# Uso:
#   ./deploy.sh          - Despliegue completo (git pull, composer, migrate, assets, cache)
#   ./deploy.sh --fix    - Solo corrección rápida (assets, cache, PHP-FPM)

set -e

# Directorio de la app
APP_DIR="${APP_DIR:-/var/www/laravel-esl-app}"
if [ ! -d "$APP_DIR" ]; then
    APP_DIR="$(cd "$(dirname "$0")" && pwd)"
fi
cd "$APP_DIR"

# Modo: full o fix
MODE="full"
if [ "$1" = "--fix" ] || [ "$1" = "-f" ] || [ "$1" = "fix" ]; then
    MODE="fix"
fi

echo "=========================================="
echo "  Laravel ESL App - $([ "$MODE" = "fix" ] && echo "Corrección rápida" || echo "Despliegue completo")"
echo "=========================================="

if [ "$MODE" = "full" ]; then
    echo ""
    echo "[1/8] Git pull..."
    git pull origin main 2>/dev/null || git pull origin master 2>/dev/null || git pull

    echo ""
    echo "[2/8] Composer install..."
    composer install --no-dev --optimize-autoloader --no-interaction

    echo ""
    echo "[3/8] Migraciones..."
    migrate_with_retry() {
        local max_attempts=3
        local attempt=1
        while [ $attempt -le $max_attempts ]; do
            local output
            output=$(php artisan migrate --force 2>&1) && { echo "$output"; return 0; }
            if echo "$output" | grep -qi "connection refused"; then
                echo "$output"
                echo "  ⚠ Conexión a BD rechazada. Intentando recuperar..."
                php artisan config:clear 2>/dev/null || true
                sudo systemctl start mysql 2>/dev/null || sudo systemctl start mariadb 2>/dev/null || sudo service mysql start 2>/dev/null || sudo service mariadb start 2>/dev/null || true
                sleep 3
                if [ $attempt -lt $max_attempts ]; then
                    echo "  Reintento $((attempt + 1))/$max_attempts en 5s..."
                    sleep 5
                fi
            else
                echo "$output"
                return 1
            fi
            attempt=$((attempt + 1))
        done
        echo "  ✗ No se pudo conectar a la BD tras $max_attempts intentos. Revisa .env y que MySQL esté en ejecución."
        return 1
    }
    migrate_with_retry || exit 1

    echo ""
    echo "[4/8] Instalando dependencias npm..."
    npm ci --production=false 2>/dev/null || npm install
fi

echo ""
echo "Compilando assets (npm run production)..."
npm run production

echo ""
echo "Ajustando permisos..."
chown -R www-data:www-data storage bootstrap/cache public/js public/css 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chmod -R 755 public/js public/css 2>/dev/null || true
chmod -R 644 public/js/*.js public/css/*.css 2>/dev/null || true

echo ""
echo "Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "Regenerando cachés de producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "$MODE" = "full" ]; then
    echo ""
    echo "Optimización..."
    php artisan optimize
fi

echo ""
echo "Reiniciando PHP-FPM..."
PHP_VERSION=$(php -v | head -n 1 | cut -d ' ' -f 2 | cut -d '.' -f 1,2)
if [ -f "/etc/init.d/php${PHP_VERSION}-fpm" ]; then
    service php${PHP_VERSION}-fpm restart
elif [ -f "/etc/init.d/php-fpm" ]; then
    service php-fpm restart
else
    systemctl restart php*-fpm 2>/dev/null || systemctl restart php-fpm 2>/dev/null || echo "  (PHP-FPM no detectado, omite si no aplica)"
fi

echo ""
echo "=========================================="
echo "  ¡Listo!"
echo "=========================================="
echo ""
ls -lah public/js/app.js public/css/app.css 2>/dev/null || true
echo ""
echo "Si no ves cambios, limpia la caché del navegador (Ctrl+Shift+R)"
echo ""
