#!/usr/bin/env bash

set -eo pipefail

#/app/bin/console cache:clear --no-warmup
#/app/bin/console cache:warmup

php-fpm -F -O
