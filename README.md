# Laravel ESL App

Aplicación web de aprendizaje de inglés (ESL) construida con **Laravel 13**. Permite a docentes gestionar unidades, ejercicios y seguimiento, y a estudiantes completar actividades interactivas.

## Documentación

La guía técnica completa (prerrequisitos, instalación, arquitectura, debugging, testing y despliegue) está en:

**[docs/TECHNICAL.md](docs/TECHNICAL.md)**

## Inicio rápido

### Validación en GitHub

El workflow **CI / Build and smoke test** instala las dependencias, compila los assets, revisa la sintaxis PHP, levanta la aplicación con `php artisan serve` y comprueba `/login`. No ejecuta migraciones, ya que el historial actual requiere compatibilidad y revisión antes de validarlo contra una base vacía. Para impedir merges cuando falle, configura `Build and smoke test` como *required status check* en las reglas de protección de la rama destino.

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

- PHP 8.5+ / Laravel 13
- MySQL
- Laravel Mix (Webpack)
- TinyMCE (CDN)
- maatwebsite/excel

## Licencia

MIT (base Laravel).
