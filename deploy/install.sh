#!/bin/bash

# Make Local Directories
mkdir -p /www/local/treq
if test -d "/www/local/treq/storage"
then
    rm -rf storage
else
    mv storage /www/local/treq
fi
mkdir -p /www/local/treq/storage/logs
touch /www/local/treq/storage/logs/laravel.log
mkdir -p /www/local/treq/storage/framework/views
chown -R apache:apache /www/local/treq/storage

# Stub .env file
touch /www/local/treq/storage/.env

# Confirm links to /www/local
LinkExists storage /www/local/treq/storage
LinkExists .env /www/local/treq/.env

# bootstrap cache directory writable by web server
DirectoryExists bootstrap/cache
WebWritable bootstrap/cache

# chown entire build directory to weblee
OwnedByWeblee .

# Install Vendor Packages from Composer
sudo -u weblee /home/weblee/bin/composer selfupdate
sudo -u weblee /home/weblee/bin/composer install

ResourceCacheIncremented /www/local/treq/.env

# Stub live directory for rotation logic
mkdir -p /www/treq
chown -R weblee:weblee /www/treq

MakeBuildLive

CdAndConfirm ${DIR_LIVE}

echo ** You must configure your local .env file: /www/local/treq/storage/.env **
