# Ideas for Listening – Documentación de despliegue

Aplicación Laravel para enseñanza de inglés como segundo idioma (ESL). Módulos de unidades, ejercicios, seguimiento, foro y más.

---

## Requisitos del sistema

| Dependencia | Versión mínima |
|-------------|----------------|
| **PHP** | 8.0.2 o superior |
| **Laravel** | 9.x |
| **Composer** | 2.x |
| **Node.js** | 24.x o superior (para Laravel Mix) |
| **npm** | 6.x o superior |
| **MySQL** | 5.7+ / 8.x (o MariaDB 10.3+) |

### Extensiones PHP requeridas

- BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

---

## Entorno local
## Desarrollo local con Docker

El entorno de desarrollo usa Compose y recursos separados de producción: app en `http://localhost:8001`, PostgreSQL en `localhost:5433` y un watcher de Laravel Mix.

```bash
cp .env.docker.dev.example .env.docker.dev
docker compose -f docker-compose.dev.yml --env-file .env.docker.dev -p laravel-esl-dev up -d --build
docker compose -f docker-compose.dev.yml --env-file .env.docker.dev -p laravel-esl-dev exec app php artisan storage:link
docker compose -f docker-compose.dev.yml --env-file .env.docker.dev -p laravel-esl-dev exec app php docker/init-db.php
```

Los cambios de PHP se reflejan al recargar la página; los cambios de CSS/JS los compila el servicio `assets`. Para ver sus logs:

```bash
docker compose -f docker-compose.dev.yml --env-file .env.docker.dev -p laravel-esl-dev logs -f assets
```

Para detener el entorno sin borrar la base de datos:

```bash
docker compose -f docker-compose.dev.yml --env-file .env.docker.dev -p laravel-esl-dev down
```

Los datos usan volúmenes separados por proyecto. No agregues `-v` a `down` salvo que quieras borrar la base de desarrollo.

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

## Automatización de deploy (GitHub Actions)

El deploy se ejecuta automáticamente vía **GitHub Actions + SSH** en cada push a `main`.

Flujo: `git push` → GitHub Actions → SSH → Droplet → `deploy.sh`

### Configuración inicial (una sola vez)

#### Paso 1 — Generar par de claves SSH

**macOS / Linux:**
```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/github_deploy_key -N ""
```

**Windows (PowerShell):**
```powershell
ssh-keygen -t ed25519 -C "github-actions-deploy" -f "$env:USERPROFILE\.ssh\github_deploy_key" -N '""'
```

Genera dos archivos: `github_deploy_key` (privada) y `github_deploy_key.pub` (pública).

#### Paso 2 — Agregar la clave pública al droplet

**macOS / Linux:**
```bash
ssh-copy-id -i ~/.ssh/github_deploy_key.pub TU_USUARIO@IP_DROPLET
```

**Windows (PowerShell):**
```powershell
$pub = Get-Content "$env:USERPROFILE\.ssh\github_deploy_key.pub"
ssh TU_USUARIO@IP_DROPLET "echo '$pub' >> ~/.ssh/authorized_keys"
```

#### Paso 3 — Permitir reinicio de PHP-FPM sin contraseña (en el droplet)

```bash
echo "TU_USUARIO ALL=(ALL) NOPASSWD: /bin/systemctl restart php*-fpm" | sudo tee /etc/sudoers.d/deploy
```

#### Paso 4 — Agregar secrets en GitHub

**Repositorio → Settings → Secrets and variables → Actions → New repository secret**

| Secret | Valor |
|---|---|
| `DEPLOY_SSH_KEY` | Contenido completo de `github_deploy_key` (clave privada, incluyendo `-----BEGIN` y `-----END`) |
| `DEPLOY_HOST` | IP o dominio del droplet |
| `DEPLOY_USER` | Usuario SSH del droplet (ej. `root`) |

Para obtener el contenido de la clave privada:

**macOS / Linux:** `cat ~/.ssh/github_deploy_key`

**Windows:** `Get-Content "$env:USERPROFILE\.ssh\github_deploy_key"`

#### Paso 5 — Verificar

Hacer push a `main` y revisar la ejecución en **Repositorio → Actions**.

### Uso diario

Desde cualquier dispositivo con acceso al repo:

```bash
git add .
git commit -m "feat: descripción del cambio"
git push origin main
```

No se requiere configuración adicional en el dispositivo nuevo.

### Solución de problemas

| Error | Causa probable | Solución |
|---|---|---|
| `Permission denied (publickey)` | Clave pública no está en el droplet | Repetir Paso 2 |
| `sudo: a password is required` | sudoers no configurado | Repetir Paso 3 |
| `403 Forbidden` al pushear | Cuenta sin permisos en el repo | Verificar en Settings → Collaborators |

---

## Producción (DigitalOcean Droplet)

### Requisitos del servidor

- Ubuntu 22.04 o posterior
- Docker Engine y Docker Compose plugin
- Docker Engine y Docker Compose plugin 2.17 o posterior (`up --wait`)
- Un usuario SSH con permiso para ejecutar Docker
- Nginx en el host o un proxy inverso delante del puerto local de la app

PHP, Composer, Node.js y PostgreSQL se ejecutan en contenedores; no hace falta instalarlos en el servidor.

### Preparar el servidor

Clona el repositorio en `/var/www/laravel-esl-app` y crea el archivo privado de entorno:

```bash
cd /var/www/laravel-esl-app
cp .env.docker.example .env.docker
```

Edita `.env.docker` en el servidor. Configura `APP_URL`, una `APP_KEY` estable y credenciales fuertes para PostgreSQL. Si la aplicación ya tenía una clave, conserva esa misma `APP_KEY`; cambiarla invalida sesiones y datos cifrados existentes. Genera una clave nueva con `openssl rand -base64 32` y guárdala como `APP_KEY=base64:<valor>` solo si es una instalación nueva. No subas `.env.docker` al repositorio.

La app se publica solo en `127.0.0.1:8000`, para que Nginx del host pueda conectarse sin exponer Apache directamente. Configura el proxy de tu dominio hacia `http://127.0.0.1:8000` y termina TLS en Nginx.

PostgreSQL no publica ningún puerto al host. Sus datos y los archivos subidos por la aplicación se conservan en volúmenes Docker.

### Despliegue

GitHub Actions continúa conectándose por SSH y ejecutando `deploy.sh`. El script actualiza la rama que disparó el workflow, construye la imagen, espera a PostgreSQL, ejecuta migraciones y actualiza los contenedores:

```bash
chmod +x deploy.sh
./deploy.sh
```

Para reconstruir y reiniciar sin traer código ni ejecutar migraciones:

```bash
./deploy.sh --fix
```

El usuario SSH debe pertenecer al grupo `docker` o tener permisos equivalentes. Ya no se reinicia PHP-FPM del host.

### Primer arranque y datos

El deploy ejecuta migraciones, pero no carga seeders automáticamente. Para una instalación nueva que necesita los datos iniciales definidos por los seeders, ejecuta una sola vez:

```bash
docker compose --env-file .env.docker run --rm --no-deps app php docker/init-db.php
```

Si vas a pasar datos existentes de MySQL a PostgreSQL, ese traslado debe hacerse por separado antes de apuntar producción a la nueva base. Cambiar el motor en Compose no convierte ni copia los datos.

Para revisar servicios y logs:

```bash
docker compose --env-file .env.docker ps
docker compose --env-file .env.docker logs -f app db
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
