#!/bin/bash

# Script para aplicar cambios visuales en producción
# Ejecutar como root en el servidor

cd /var/www/laravel-esl-app

echo "1. Recompilando assets..."
npm run production

echo "2. Corrigiendo permisos de archivos compilados..."
chown -R www-data:www-data public/js public/css
chmod -R 644 public/js/*.js public/css/*.css 2>/dev/null
chmod -R 755 public/js public/css

echo "3. Limpiando todos los caches de Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "4. Regenerando caches de producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "5. Reiniciando PHP-FPM..."
# Detectar versión de PHP
PHP_VERSION=$(php -v | head -n 1 | cut -d ' ' -f 2 | cut -d '.' -f 1,2)
if [ -f "/etc/init.d/php${PHP_VERSION}-fpm" ]; then
    service php${PHP_VERSION}-fpm restart
elif [ -f "/etc/init.d/php-fpm" ]; then
    service php-fpm restart
else
    systemctl restart php*-fpm 2>/dev/null || systemctl restart php-fpm 2>/dev/null || echo "No se pudo reiniciar PHP-FPM automáticamente"
fi

echo "6. Verificando permisos finales..."
ls -lah public/js/app.js
ls -lah public/css/app.css

echo "¡Listo! Los cambios deberían estar reflejados ahora."
echo "Si aún no ves los cambios, limpia la cache de tu navegador (Ctrl+Shift+R)"
