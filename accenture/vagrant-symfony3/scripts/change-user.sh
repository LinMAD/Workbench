#!/usr/bin/env bash

#Change user of nginx and php-fpm
yes | sudo cp -rf /vagrant/config/nginx.conf /etc/nginx/nginx.conf
yes | sudo cp -rf /vagrant/config/www.conf /usr/local/etc/php-fpm.d/www.conf

sudo service nginx restart
sudo service php-fpm restart