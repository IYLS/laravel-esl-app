#!/bin/bash
# Script de despliegue para producción (DigitalOcean Droplet)
# Uso: ./deploy.sh
# Ejecutar desde el directorio del proyecto o como root en /var/www/laravel-esl-app

set -e  # Salir si algún comando falla

# Directorio de la app (por defecto: droplet típico)
# Para usar otro: APP_DIR=/ruta/a/tu/app ./deploy.sh
APP_DIR="${APP_DIR:-/var/www/laravel-esl-app}"
if [ ! -d "$APP_DIR" ]; then
    APP_DIR="$(cd "$(dirname "$0")" && pwd)"
fi
cd "$APP_DIR"

echo "=========================================="
echo "  Despliegue Laravel ESL App"
echo "=========================================="

# 1. Pull de cambios
echo ""
echo "[1/8] Git pull..."
git pull origin main 2>/dev/null || git pull origin master 2>/dev/null || git pull

# 2. Composer (sin dev para producción)
echo ""
echo "[2/8] Composer install..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Migraciones (--force para producción sin confirmación)
echo ""
echo "[3/8] Ejecutando migraciones..."
php artisan migrate --force

# 4. NPM y compilación de assets
echo ""
echo "[4/8] Compilando assets..."
npm ci --production=false 2>/dev/null || npm install
npm run production

# 5. Permisos
echo ""
echo "[5/8] Ajustando permisos..."
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data public/js public/css 2>/dev/null || true

# 6. Limpiar cachés
echo ""
echo "[6/8] Limpiando cachés..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 7. Regenerar cachés de producción
echo ""
echo "[7/8] Regenerando cachés de producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Optimización
echo ""
echo "[8/8] Optimización..."
php artisan optimize

echo ""
echo "=========================================="
echo "  ¡Despliegue completado!"
echo "=========================================="
echo ""
echo "Si usas PHP-FPM, reinicia el servicio:"
echo "  sudo systemctl restart php*-fpm"
echo ""
