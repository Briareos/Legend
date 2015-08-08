#!/bin/sh
set -e
errors=$(/opt/{{ php7_version }}/sbin/php-fpm --fpm-config /opt/{{ php7_version }}/etc/php-fpm.conf -t 2>&1 | grep "\[ERROR\]" || true);
if [ -n "$errors" ]; then
    echo "Please fix your configuration file..."
    echo $errors
    exit 1
fi
exit 0
