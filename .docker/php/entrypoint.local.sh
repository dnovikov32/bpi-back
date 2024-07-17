#!/usr/bin/env bash

set -eo pipefail

#until nc -vz ${POSTGRES_HOST} ${POSTGRES_PORT}; do echo waiting for ${POSTGRES_HOST}; sleep 3; done
#/app/bin/console cache:clear --no-warmup
#/app/bin/console cache:warmup

composer install --no-interaction --no-scripts --no-progress

php-fpm -F -O
