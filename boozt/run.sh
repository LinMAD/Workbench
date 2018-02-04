#!/usr/bin/env bash

# Run app in docker container, name of container boozt-test-app
docker run --rm --tty \
    -p 8088:80 \
    --name boozt-test-app \
    -v `pwd`:/var/www/html php:7.2-apache

if [ $? -ne 0 ]; then
      echo "Failed to run docker php:7.2-apache image with app"
      exit 1
fi
