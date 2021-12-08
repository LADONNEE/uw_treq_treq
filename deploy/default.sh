#!/bin/bash

# Copy directories no in source control into place
CopiedFromLive vendor

# Confirm links to /www/local
FileDeleted storage
LinkExists storage /www/local/treq/storage
LinkExists .env /www/local/treq/.env

# bootstrap cache directory writable by web server
DirectoryExists bootstrap/cache
WebWritable bootstrap/cache

# Clean up logs
LogFilesPruned 30 '/www/local/treq/storage/logs/*'
LogFileRotated /www/local/treq/storage/logs/laravel.log

# Get rid of compiled views
FileDeleted /www/local/treq/storage/framework/views/*

# chown entire build directory to weblee
OwnedByWeblee .

ResourceCacheIncremented /www/local/treq/.env

MakeBuildLive

CdAndConfirm ${DIR_LIVE}

php artisan config:cache
php artisan route:cache
