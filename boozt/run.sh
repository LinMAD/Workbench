#!/usr/bin/env bash

# Check if docker exist in system
if ! hash docker 2>/dev/null
then
    echo "'docker' was not found in your OS system: `uname`"
    exit 1
fi

# Check if composer crated PSR4 autoloader
if [ ! -d `pwd`/vendor ]; then
    docker run --rm \
        --name composer \
        --interactive \
        --tty \
        --net host \
        --volume `pwd`:/app \
        --workdir /app \
        --user $(id -u):$(id -g) \
    composer:latest "install"

    if [ $? -ne 0 ]; then
          echo "Composer install in docker failed"
          exit 1
    fi
fi


# Create docker network for app
docker network create boozt-net
if [ $? -ne 0 ]; then
      docker network rm boozt-net
      docker network create boozt-net
      if [ $? -ne 0 ]; then
          echo "Unable to create docker network(boozt-net) of test app"
          exit 1
      fi
fi

# Build php custom image
docker build -f `pwd`/Docker/php/Dockerfile . -t boozt-php72:latest
if [ $? -ne 0 ]; then
      echo "Failed to build docker image boozt-php72 -> pwd -> `pwd`/Docker/Dockerfile "
      exit 1
fi

# Build MySQL percona container
docker run --name boozt-test-app-db \
     -e MYSQL_ROOT_PASSWORD=my-secret-pw \
     -v `pwd`/Docker/mysql/:/docker-entrypoint-initdb.d \
     --net boozt-net \
     -d percona:5.7
if [ $? -ne 0 ]; then
      echo "Failed to create database"
      exit 1
fi

# Show short cut link
echo "Visit your localhost at 8088 port -> http://127.0.0.1:8088 if all assembled correctly"

## Run container
docker run --rm --tty \
    -p 8088:80 \
    --net boozt-net \
    --name boozt-test-app \
    -v `pwd`:/var/www/html boozt-php72:latest
if [ $? -ne 0 ]; then
      echo "Failed to run docker boozt-php72:latest custom image with app"
      exit 1
fi
