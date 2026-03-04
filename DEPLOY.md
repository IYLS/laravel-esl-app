# Despliegue en producción (DigitalOcean)

## Despliegue completo (después de `git pull`)

```bash
# Dar permisos de ejecución la primera vez
chmod +x deploy.sh

# Ejecutar (como root o con sudo)
./deploy.sh
```

O manualmente:

```bash
cd /var/www/laravel-esl-app

# 1. Dependencias PHP
composer install --no-dev --optimize-autoloader

# 2. Migraciones (IMPORTANTE: --force en producción)
php artisan migrate --force

# 3. Assets
npm ci
npm run production

# 4. Permisos
chown -R www-data:www-data storage bootstrap/cache public/js public/css

# 5. Cachés
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Solo corrección visual / caché

Si ya desplegaste y solo necesitas refrescar cachés y assets:

```bash
./deploy-fix.sh
```

## Variables de entorno

Asegúrate de tener en `.env`:

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL` correcto
- Credenciales de base de datos

## Migraciones

Las migraciones están preparadas para ejecutarse de forma segura en producción:

- Las tablas de reacciones se crean solo si no existen
- La migración `add_columns_to_reaction_tables` maneja tanto tablas nuevas como existentes
- Usa siempre `php artisan migrate --force` en producción (evita el prompt de confirmación)
