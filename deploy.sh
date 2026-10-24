#!/usr/bin/env bash
set -Eeuo pipefail

APP_DIR="${APP_DIR:-/var/www/laravel-esl-app}"
if [[ ! -d "$APP_DIR" ]]; then
    APP_DIR="$(cd "$(dirname "$0")" && pwd)"
fi
cd "$APP_DIR"

MODE="full"
case "${1:-}" in
    --fix|-f|fix) MODE="fix" ;;
esac

if [[ ! -f .env.docker ]]; then
    echo "Falta .env.docker. Créalo a partir de .env.docker.example y configura sus valores." >&2
    exit 1
fi

if ! docker compose version >/dev/null 2>&1; then
    echo "Docker Compose plugin no está instalado o no está disponible para este usuario." >&2
    exit 1
fi

COMPOSE=(docker compose --env-file .env.docker)

if [[ "$MODE" == "full" ]]; then
    DEPLOY_BRANCH="${DEPLOY_BRANCH:-main}"
    echo "Actualizando código desde origin/$DEPLOY_BRANCH..."
    git pull --ff-only origin "$DEPLOY_BRANCH"
fi

echo "Validando configuración de Compose..."
"${COMPOSE[@]}" config --quiet

echo "Construyendo imagen de producción..."
"${COMPOSE[@]}" build --pull app

echo "Esperando a PostgreSQL..."
"${COMPOSE[@]}" up --detach --wait db

if [[ "$MODE" == "full" ]]; then
    echo "Ejecutando migraciones..."
    "${COMPOSE[@]}" run --rm --no-deps app php artisan migrate --force
fi

echo "Levantando la aplicación..."
"${COMPOSE[@]}" up --detach --remove-orphans --wait
"${COMPOSE[@]}" exec -T app php artisan optimize
"${COMPOSE[@]}" ps

echo "Despliegue Docker completado."

"${COMPOSE[@]}" ps
echo "Limpiando imágenes y caché de build antiguos..."
docker image prune -f
docker builder prune -f --filter "until=168h"