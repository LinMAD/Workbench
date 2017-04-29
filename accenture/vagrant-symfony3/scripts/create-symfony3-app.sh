#!/usr/bin/env bash

PROJECT_NAME=$1

if [ $# -eq 0 ]
  then
    echo "No symfony app name supplied!"
    exit 1;
fi

cd /vagrant/scripts

# change user of nginx and php-fpm
./change-user.sh

## create database
./create-mysql.sh $PROJECT_NAME

## config new project on nginx
./create-sites-symfony.sh $PROJECT_NAME

## download symfony standard project
sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
sudo chmod a+x /usr/local/bin/symfony

cd /vagrant/sites/ && symfony new $PROJECT_NAME
## overwrite app_dev
cp /vagrant/config/app_dev.php /vagrant/sites/$PROJECT_NAME/web/
cp /vagrant/config/parameters.yml /vagrant/sites/$PROJECT_NAME/app/config/
cd /vagrant/sites/$PROJECT_NAME && composer --prefer-dist install
