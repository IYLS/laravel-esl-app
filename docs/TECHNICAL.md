# Documentación técnica — Laravel ESL App

Aplicación web para aprendizaje de inglés (ESL) basada en **Laravel 9**. Incluye módulo de docente (gestión de unidades, ejercicios, feedback, tracking) y módulo de estudiante (selección de nivel, resolución de ejercicios, foro).

---

## 1. Stack tecnológico

| Componente | Versión / detalle |
|---|---|
| PHP | `^8.0.2` (recomendado **8.1–8.2** para Laravel 9) |
| Framework | Laravel **9.x** |
| Base de datos | **MySQL** (pdo_mysql) |
| Frontend assets | Laravel Mix 6 + Webpack |
| Autenticación | Sesión Laravel (roles `teacher` / `student`) |
| Excel | maatwebsite/excel 3.x (export de tracking) |
| Editor rich text | TinyMCE 6 vía CDN |
| Testing | PHPUnit 9 |

Zona horaria de la app: `America/Santiago` (`config/app.php`).

---

## 2. Prerrequisitos

### Software obligatorio

- **PHP 8.0.2+** (idealmente 8.1 o 8.2) con extensiones:
  - `bcmath`, `ctype`, `fileinfo`, `json`, `mbstring`, `openssl`
  - `pdo`, `pdo_mysql`, `tokenizer`, `xml`, `curl`
- **Composer** 2.x
- **Node.js** 16+ y **npm** (para compilar assets con Mix)
- **MySQL** 5.7+ / 8.x (o MariaDB equivalente)
- **Git**

### Verificar instalación

```bash
php -v
composer -V
node -v
npm -v
mysql --version
```

### Extensiones PHP

```bash
php -m | grep -iE 'pdo_mysql|mbstring|openssl|tokenizer|xml|ctype|json|bcmath|fileinfo|curl'
```

---

## 3. Instalación y levantamiento

### 3.1 Clonar el repositorio

```bash
git clone <url-del-repositorio> laravel-esl-app
cd laravel-esl-app
```

### 3.2 Dependencias PHP

```bash
composer install
```

### 3.3 Variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` y configurar al menos:

```env
APP_NAME="Laravel ESL App"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_esl
DB_USERNAME=root
DB_PASSWORD=tu_password
```

Crear la base de datos en MySQL:

```sql
CREATE DATABASE laravel_esl CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3.4 Migraciones y seeders

```bash
php artisan migrate --seed
```

Esto crea el esquema y carga datos de demo (grupos, usuarios, unidades, ejercicios, etc.).

### 3.5 Enlace de almacenamiento

```bash
php artisan storage:link
```

### 3.6 Assets frontend

```bash
npm install
npm run dev          # desarrollo
# npm run watch      # recompilar al cambiar archivos
# npm run prod       # build de producción
```

### 3.7 Servidor de desarrollo

```bash
php artisan serve
```

Abrir: [http://127.0.0.1:8000](http://127.0.0.1:8000)

Login: [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

---

## 4. Credenciales de desarrollo (seeders)

Tras `migrate --seed`, existen usuarios de prueba definidos en `database/seeders/UserSeeder.php`:

| Rol | Email | Password (seed) | Notas |
|---|---|---|---|
| Teacher | `admin@iyls.com` | `isopropyl360` | Rol `teacher` |
| Teacher | `monica@ideasforlistening.com` | `123456` | Rol `teacher` |
| Student | `benjamin.caceres.ra@gmail.com` | `isopropyl360` | Varios registros con mismo email; el login también exige `role` |

> **Importante:** el formulario de login valida `email`, `password` y `role`. Seleccionar el rol correcto al autenticarse. Estas credenciales son solo para entornos locales; cambiarlas fuera de desarrollo.

---

## 5. Arquitectura de la aplicación

### Roles y middleware

| Middleware | Clase | Uso |
|---|---|---|
| `teacher` | `App\Http\Middleware\TeacherLoggedIn` | Rutas de docente |
| `student` | `App\Http\Middleware\StudentLoggedIn` | Rutas de estudiante |
| `auth` | `App\Http\Middleware\Authenticate` | Autenticación genérica |

### Módulos principales

| Dominio | Controlador | Descripción |
|---|---|---|
| Auth | `AuthController` | Login / logout / home |
| Usuarios | `UserController` | CRUD de usuarios |
| Grupos | `GroupController` | Grupos/cursos |
| Unidades | `UnitController` | Unidades de aprendizaje |
| Secciones | `SectionController` | Secciones dentro de una unidad |
| Ejercicios | `ExerciseController` | Tipos de ejercicio |
| Preguntas | `QuestionController` | Preguntas por ejercicio |
| Feedback | `FeedbackController` | Retroalimentación |
| Keywords | `KeywordController` | Palabras clave por unidad |
| Glossed words | `GlossedWordsController` | Glosas |
| Estudiante | `StudentController` | Flujo del alumno |
| Tracking | `TrackingController` | Seguimiento + export Excel |
| Foro | `ForumController` / `ReplyController` | Comentarios y respuestas |

### Tipos de ejercicio (seed)

1. Drag and Drop  
2. Multiple choice  
3. Fill in the gaps  
4. Open ended  
5. Voice Recognition  
6. Form  

Rutas web: `routes/web.php`. Rutas API auxiliares: `routes/api.php`.

### Estructura de carpetas relevante

```
app/
  Http/Controllers/   # Controladores por dominio
  Http/Middleware/    # student / teacher / auth
  Http/Requests/      # Form requests de ejercicios
  Models/             # Eloquent
  Exports/            # ExportTracking (Excel)
database/
  migrations/
  seeders/
resources/
  views/              # Blade (auth, units, student, tracking…)
  js/ / css/          # Fuentes de Mix
routes/
  web.php
  api.php
storage/logs/         # Logs de aplicación
docs/                 # Esta documentación
```

---

## 6. Comandos útiles

```bash
# Cachés
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Base de datos
php artisan migrate
php artisan migrate:fresh --seed   # ¡destruye datos!
php artisan db:seed

# Rutas
php artisan route:list

# Tinker (REPL)
php artisan tinker

# Storage
php artisan storage:link
```

### Rutas API de mantenimiento (solo desarrollo)

Definidas en `routes/api.php`. **No deben exponerse en producción** sin protección:

| Endpoint | Acción |
|---|---|
| `GET /api/migrate` | Ejecuta `migrate` |
| `GET /api/migrate_fresh_seed` | `migrate:fresh --seed` |
| `GET /api/seed` | `db:seed` |
| `GET /api/config_cache` | Limpia/reconfigura cachés |
| `GET /api/link_storage` | `storage:link` |

---

## 7. Debugging

### 7.1 Modo debug

En `.env`:

```env
APP_ENV=local
APP_DEBUG=true
LOG_LEVEL=debug
```

Con `APP_DEBUG=true`, Laravel muestra la página de error de Spatie Ignition (stack trace, query, request).

> En producción: `APP_DEBUG=false` y `APP_ENV=production`.

### 7.2 Logs

```bash
tail -f storage/logs/laravel.log
```

Canal por defecto: `stack` → `single` (`config/logging.php`).

### 7.3 Inspección con Tinker

```bash
php artisan tinker
```

Ejemplos:

```php
\App\Models\User::where('role', 'teacher')->get();
\App\Models\Unit::with('sections')->first();
auth()->attempt(['email' => '...', 'password' => '...', 'role' => 'teacher']);
```

### 7.4 Rutas y middleware

```bash
php artisan route:list
php artisan route:list --path=student
php artisan route:list --path=tracking
```

### 7.5 Base de datos

```bash
php artisan migrate:status
```

Errores frecuentes de conexión: revisar `DB_*` en `.env`, que MySQL esté arriba y que exista la BD.

### 7.6 Assets / Mix

Si CSS/JS no cargan:

```bash
npm run dev
# o
npm run watch
```

Verificar que existan `public/js/app.js` y `public/css/app.css`.

### 7.7 Sesión / login

1. Confirmar que el usuario tiene el `role` correcto (`teacher` | `student`).
2. El intento de login incluye `role` en las credenciales (`AuthController::authenticate`).
3. Limpiar cookies/sesión o `php artisan session:table` no aplica (driver `file` por defecto): borrar `storage/framework/sessions/*`.

### 7.8 Xdebug (opcional)

Si usas Xdebug, configurar el IDE para escuchar el puerto (habitualmente `9003`) y lanzar requests contra `php artisan serve` o el virtual host.

### 7.9 Checklist rápido de fallos

| Síntoma | Qué revisar |
|---|---|
| 500 genérico | `storage/logs/laravel.log`, `APP_DEBUG=true` |
| `No application encryption key` | `php artisan key:generate` |
| Error de conexión DB | `.env` `DB_*`, MySQL corriendo |
| Página sin estilos | `npm run dev`, Mix |
| Imágenes/archivos 404 | `php artisan storage:link` |
| CSRF 419 | Sesión/cookies; no mezclar HTTP/HTTPS |
| Login falla | Email + password + role; usuario `activated` (estudiantes) |
| Permisos en storage | `chmod -R ug+rwx storage bootstrap/cache` |

---

## 8. Testing

```bash
php artisan test
# o
./vendor/bin/phpunit
```

Suites en `phpunit.xml`:

- `tests/Unit`
- `tests/Feature`

Variables de testing: `APP_ENV=testing`, cache/sesión/mail en `array`, queue `sync`.

Para tests con SQLite en memoria, descomentar en `phpunit.xml`:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

---

## 9. Despliegue (resumen)

1. `composer install --optimize-autoloader --no-dev`
2. Configurar `.env` de producción (`APP_DEBUG=false`)
3. `php artisan key:generate` (solo si aún no hay `APP_KEY`)
4. `php artisan migrate --force`
5. `npm ci && npm run prod`
6. `php artisan storage:link`
7. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
8. Apuntar el document root del servidor web a `public/`
9. Deshabilitar o proteger las rutas de mantenimiento en `routes/api.php`

---

## 10. Convenciones de desarrollo

- Controladores delgados; validación preferible en `FormRequest` (`app/Http/Requests`).
- Vistas Blade organizadas por dominio bajo `resources/views/`.
- Nuevas tablas vía migraciones; datos iniciales vía seeders.
- Zona horaria fija en `America/Santiago`.
- No commitear `.env`, `vendor/`, `node_modules/` ni logs.

---

## 11. Referencias

- [Laravel 9 docs](https://laravel.com/docs/9.x)
- [Laravel Mix](https://laravel-mix.com/)
- [Maatwebsite Excel](https://docs.laravel-excel.com/)
- Código de rutas: `routes/web.php`
- Seeders: `database/seeders/`
