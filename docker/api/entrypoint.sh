#!/bin/sh

set -e

php bin/console doctrine:database:create  --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:database:create  --env test --if-not-exists
php bin/console doctrine:migrations:migrate --env test --no-interaction

exec "$@"
