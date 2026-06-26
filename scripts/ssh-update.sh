#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-$HOME/laravel-lokersmaafbs}"
PUBLIC_DIR="${PUBLIC_DIR:-$HOME/public_html/web/www.karir}"
REPO_URL="${REPO_URL:-https://github.com/Mubaleghjoss/loker-smaafbs.git}"
BRANCH="${BRANCH:-main}"

resolve_php_bin() {
    if [ -n "${PHP_BIN:-}" ] && [ -x "$PHP_BIN" ]; then
        printf '%s\n' "$PHP_BIN"
        return 0
    fi

    for candidate in \
        /opt/cpanel/ea-php82/root/usr/bin/php \
        /usr/local/bin/ea-php82 \
        /usr/bin/ea-php82 \
        /opt/alt/php82/usr/bin/php \
        /usr/local/bin/php82
    do
        if [ -x "$candidate" ]; then
            printf '%s\n' "$candidate"
            return 0
        fi
    done

    command -v php
}

PHP_BIN="$(resolve_php_bin)"
PHP_VERSION="$("$PHP_BIN" -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')"

if [ "$PHP_VERSION" != "8.2" ]; then
    echo "ERROR: PHP 8.2 is required, but '$PHP_BIN' is PHP $PHP_VERSION."
    echo "Set PHP_BIN manually, for example:"
    echo "PHP_BIN=/opt/cpanel/ea-php82/root/usr/bin/php bash scripts/ssh-update.sh"
    exit 1
fi

run_composer() {
    local composer_path="${COMPOSER_BIN:-}"

    if [ -z "$composer_path" ]; then
        composer_path="$(command -v composer || true)"
    fi

    if [ -n "$composer_path" ] && [ -f "$composer_path" ]; then
        "$PHP_BIN" "$composer_path" "$@"
        return
    fi

    if [ -f "$APP_DIR/composer.phar" ]; then
        "$PHP_BIN" "$APP_DIR/composer.phar" "$@"
        return
    fi

    if command -v composer >/dev/null 2>&1; then
        composer "$@"
        return
    fi

    echo "ERROR: Composer was not found. Set COMPOSER_BIN to the composer path."
    exit 1
}

echo "==> App dir: $APP_DIR"
echo "==> Public dir: $PUBLIC_DIR"
echo "==> PHP: $PHP_BIN ($("$PHP_BIN" -v | head -n 1))"

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

COMPOSER_FLAGS=(install --no-dev --prefer-dist --optimize-autoloader)

if ! "$PHP_BIN" -r 'exit(function_exists("proc_open") ? 0 : 1);'; then
    echo "==> proc_open is disabled; running Composer with --no-scripts and artisan manually."
    COMPOSER_FLAGS+=(--no-scripts)
fi

run_composer "${COMPOSER_FLAGS[@]}"

"$PHP_BIN" artisan package:discover --ansi

if grep -q '^APP_KEY=$' .env; then
    "$PHP_BIN" artisan key:generate --force
fi

"$PHP_BIN" artisan migrate --force
"$PHP_BIN" artisan optimize:clear
"$PHP_BIN" artisan config:cache
"$PHP_BIN" artisan route:cache
"$PHP_BIN" artisan view:cache

mkdir -p "$PUBLIC_DIR"

if command -v rsync >/dev/null 2>&1; then
    rsync -a --exclude=index.php "$APP_DIR/public/" "$PUBLIC_DIR/"
else
    cp -a "$APP_DIR/public/." "$PUBLIC_DIR/"
fi

cp "$APP_DIR/deploy/public-index.php" "$PUBLIC_DIR/index.php"

echo "==> Deploy complete."
