#!/bin/sh
set -e

cd /var/www/html

php docker/init-db.php

exec "$@"
