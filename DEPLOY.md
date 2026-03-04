# Ideas for Listening – Documentación de despliegue

Aplicación Laravel para enseñanza de inglés como segundo idioma (ESL). Módulos de unidades, ejercicios, seguimiento, foro y más.

---

## Requisitos del sistema

| Dependencia | Versión mínima |
|-------------|----------------|
| **PHP** | 8.0.2 o superior |
| **Laravel** | 9.x |
| **Composer** | 2.x |
| **Node.js** | 14.x o superior (para Laravel Mix) |
| **npm** | 6.x o superior |
| **MySQL** | 5.7+ / 8.x (o MariaDB 10.3+) |

### Extensiones PHP requeridas

- BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## Entorno local

### 1. Clonar e instalar

```bash
git clone <repo-url> laravel-esl-app
cd laravel-esl-app
```

### 2. Dependencias PHP

```bash
composer install
```

### 3. Variables de entorno

```bash
cp .env.example .env   # Si no existe .env.example, crear .env manualmente
php artisan key:generate
```

Editar `.env` con la configuración local:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_esl
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Base de datos

```bash
php artisan migrate
```

### 5. Storage (enlaces simbólicos)

```bash
php artisan storage:link
```

### 6. Assets (CSS/JS)

```bash
npm install
npm run dev
```

Para desarrollo con recarga automática:

```bash
npm run watch
```

### 7. Servidor de desarrollo

```bash
php artisan serve
```

Abrir `http://localhost:8000`.

---

## Producción (DigitalOcean Droplet)

### Requisitos del servidor

- Ubuntu 20.04 o 22.04
- PHP 8.0+ con FPM
- Nginx o Apache
- MySQL/MariaDB
- Node.js y npm (para compilar assets)

### Script de despliegue

El proyecto incluye `deploy.sh` para automatizar el despliegue:

```bash
chmod +x deploy.sh
./deploy.sh
```

**Despliegue completo** (tras `git pull`):

- Git pull
- `composer install --no-dev`
- Migraciones
- Compilación de assets
- Permisos
- Cachés de producción
- Reinicio de PHP-FPM

**Corrección rápida** (solo assets y cachés):

```bash
./deploy.sh --fix
```

### Despliegue manual

```bash
cd /var/www/laravel-esl-app

composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm ci && npm run production
chown -R www-data:www-data storage bootstrap/cache public
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Variables de entorno en producción

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=laravel_esl
DB_USERNAME=...
DB_PASSWORD=...
```

---

## Estructura relevante del proyecto

```
laravel-esl-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── ForumController.php
│   │   ├── ReplyController.php
│   │   ├── ReactionController.php
│   │   └── ...
│   └── Models/
├── database/migrations/
├── public/
│   ├── css/app.css      # Compilado desde resources/css
│   └── js/app.js
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
├── routes/web.php
├── deploy.sh
└── webpack.mix.js       # Laravel Mix (no Vite)
```

### Stack frontend

- **Bootstrap 5**
- **Laravel Mix** (Webpack) para compilar CSS/JS
- **jQuery** + **jQuery UI** (drag & drop)
- **TinyMCE** (editores ricos)
- **Material Symbols** (iconos)

---

## Base de datos

- **Motor**: MySQL/MariaDB
- **Migraciones**: `php artisan migrate`
- En producción: `php artisan migrate --force`

### Tablas principales

- `users`, `groups`, `units`, `sections`, `exercises`, `questions`
- `comments`, `replies` (foro)
- `comment_reactions`, `reply_reactions` (emojis en foro)
- `tracking`, `user_responses`

---

## Storage y permisos

- `storage/app/public` – archivos subidos (avatars, videos, etc.)
- `storage/logs` – logs de Laravel
- `bootstrap/cache` – caché de configuración

En producción:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## Comandos útiles

| Comando | Descripción |
|---------|-------------|
| `php artisan migrate --force` | Migraciones en producción |
| `php artisan config:clear` | Limpiar caché de configuración |
| `php artisan route:clear` | Limpiar caché de rutas |
| `php artisan view:clear` | Limpiar vistas compiladas |
| `php artisan cache:clear` | Limpiar caché de aplicación |
| `npm run production` | Compilar assets para producción |

---

## Solución de problemas

### Los cambios de CSS/JS no se ven

1. Ejecutar `npm run production`
2. Limpiar cachés: `php artisan view:clear && php artisan cache:clear`
3. Hard refresh en el navegador: `Ctrl+Shift+R`

### Error 500 en producción

- Revisar `storage/logs/laravel.log`
- Comprobar permisos de `storage` y `bootstrap/cache`
- Verificar `.env` y `APP_KEY`

### Migraciones fallan

- Comprobar credenciales de BD en `.env`
- En producción usar siempre `--force`
- Las migraciones de reacciones comprueban si las tablas existen antes de crearlas

### PHP-FPM no se reinicia

El script intenta detectar la versión. Si falla:

```bash
sudo systemctl restart php8.1-fpm   # Ajustar versión
```

---

## Notas para el futuro

- **Laravel 9** usa PHP 8.0+. Una futura actualización a Laravel 10+ requerirá PHP 8.1+.
- Los assets se compilan con **Laravel Mix** (Webpack). No se usa Vite.
- El foro usa reacciones con emojis vía AJAX; las rutas de reacciones requieren autenticación.
- Los profesores ven todos los comentarios del foro; los estudiantes solo los de su grupo.
