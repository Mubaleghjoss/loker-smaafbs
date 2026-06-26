#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-$HOME/laravel-lokersmaafbs}"
PUBLIC_DIR="${PUBLIC_DIR:-$HOME/public_html/web/www.karir}"
REPO_URL="${REPO_URL:-https://github.com/Mubaleghjoss/loker-smaafbs.git}"
BRANCH="${BRANCH:-main}"

echo "==> App dir: $APP_DIR"
echo "==> Public dir: $PUBLIC_DIR"

if [ ! -d "$APP_DIR/.git" ]; then
    mkdir -p "$(dirname "$APP_DIR")"
    git clone --branch "$BRANCH" "$REPO_URL" "$APP_DIR"
else
    cd "$APP_DIR"
    git fetch origin "$BRANCH"
    git reset --hard "origin/$BRANCH"
fi

cd "$APP_DIR"

if [ ! -f .env ]; then
    cp .env.production.example .env
    echo "==> Created .env from .env.production.example"
    echo "==> Edit .env with real APP_KEY, APP_URL, and MySQL credentials, then rerun this script."
    exit 1
fi

composer install --no-dev --prefer-dist --optimize-autoloader

if grep -q '^APP_KEY=$' .env; then
    php artisan key:generate --force
fi

php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

mkdir -p "$PUBLIC_DIR"

if command -v rsync >/dev/null 2>&1; then
    rsync -a --exclude=index.php "$APP_DIR/public/" "$PUBLIC_DIR/"
else
    cp -a "$APP_DIR/public/." "$PUBLIC_DIR/"
fi

cp "$APP_DIR/deploy/public-index.php" "$PUBLIC_DIR/index.php"

echo "==> Deploy complete."
