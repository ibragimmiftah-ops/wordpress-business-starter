#!/usr/bin/env bash
set -euo pipefail

if [ ! -f .env ]; then
  echo "Missing .env. Copy .env.example to .env and change credentials first."
  exit 1
fi

set -a
. ./.env
set +a

: "${SITE_URL:?SITE_URL is required}"
: "${SITE_TITLE:?SITE_TITLE is required}"
: "${ADMIN_USER:?ADMIN_USER is required}"
: "${ADMIN_PASSWORD:?ADMIN_PASSWORD is required}"
: "${ADMIN_EMAIL:?ADMIN_EMAIL is required}"

if docker compose run --rm wpcli core is-installed >/dev/null 2>&1; then
  echo "WordPress is already installed."
else
  docker compose run --rm wpcli core install \
    --url="$SITE_URL" \
    --title="$SITE_TITLE" \
    --admin_user="$ADMIN_USER" \
    --admin_password="$ADMIN_PASSWORD" \
    --admin_email="$ADMIN_EMAIL" \
    --skip-email
fi

docker compose run --rm wpcli theme activate business-starter
docker compose run --rm wpcli plugin activate business-starter-core
docker compose run --rm wpcli rewrite structure '/%postname%/' --hard
docker compose run --rm wpcli option update timezone_string 'Europe/Helsinki'
docker compose run --rm wpcli option update default_comment_status closed

echo "Starter activated: $SITE_URL/wp-admin"
