#!/bin/sh
touch database/stubdb.sqlite
touch database/testing.sqlite
rm database/stubdb.sqlite
rm database/testing.sqlite
touch database/stubdb.sqlite
php artisan migrate --database="setup" --env="testing"
php artisan db:seed --database="setup" --env="testing"
cp -v database/stubdb.sqlite database/testing.sqlite
