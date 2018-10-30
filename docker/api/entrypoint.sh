#!/bin/sh

set -e

php bin/console doctrine:database:create  --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction

exec "$@"
