FROM php:7.2-apache

RUN apt-get update && apt-get install -y

# ADD PDO
RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 80
CMD ["apache2-foreground"]