# Laravel ESL App

Aplicación web de aprendizaje de inglés (ESL) construida con **Laravel 9**. Permite a docentes gestionar unidades, ejercicios y seguimiento, y a estudiantes completar actividades interactivas.

## Documentación

La guía técnica completa (prerrequisitos, instalación, arquitectura, debugging, testing y despliegue) está en:

**[docs/TECHNICAL.md](docs/TECHNICAL.md)**

## Inicio rápido

### Con Docker (recomendado para desarrollo local)

Requiere Docker Desktop con Docker Compose. La aplicación usa PHP 8.5 y Laravel 13. En PowerShell, desde la raíz del proyecto:

```powershell
Copy-Item .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

Abrir [http://localhost:8000/login](http://localhost:8000/login). MySQL queda disponible en `localhost:3307`.
Para detener los contenedores sin borrar la base de datos: `docker compose down`.

### Validación en GitHub

El workflow **CI / Build and smoke test** construye la imagen Docker, revisa la sintaxis PHP, levanta los contenedores y comprueba `/login`. No ejecuta migraciones, ya que el historial actual requiere compatibilidad y revisión antes de validarlo contra una base vacía. Para impedir merges cuando falle, configura `Build and smoke test` como *required status check* en las reglas de protección de la rama destino.

### Instalación manual

```bash
# 1. Dependencias
composer install
cp .env.example .env
php artisan key:generate

# 2. Configurar DB_* en .env y crear la base MySQL
php artisan migrate --seed
php artisan storage:link

# 3. Assets
npm install
npm run dev

# 4. Servidor
php artisan serve
```

Abrir [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login).

Credenciales de demo tras el seeder: ver [docs/TECHNICAL.md §4](docs/TECHNICAL.md#4-credenciales-de-desarrollo-seeders).

## Stack

- PHP 8.0+ / Laravel 9
- MySQL
- Laravel Mix (Webpack)
- TinyMCE (CDN)
- maatwebsite/excel

## Licencia

MIT (base Laravel).
