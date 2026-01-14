# PHP + Apache base image
FROM php:8.2-apache

# Install PDO MySQL extension (needed for PDO connection)
RUN docker-php-ext-install pdo pdo_mysql

# Copy app source into Apache web root
COPY src/ /var/www/html/

# Expose Apache port
EXPOSE 80
