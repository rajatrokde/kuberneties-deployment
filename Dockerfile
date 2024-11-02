# Use the official PHP image with Apache
FROM php:7.4-apache

# Install MySQLi extension
RUN docker-php-ext-install mysqli

# Copy the HTML form and PHP submission script into the container
COPY ./index.html /var/www/html/index.html
COPY ./submit.php /var/www/html/submit.php

# Expose port 80 to the outside world
EXPOSE 80
