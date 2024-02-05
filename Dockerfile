# Use the official PHP image with Apache, PHP 8.0
FROM php:8.0-apache

# Copy the current directory contents into the container at /var/www/html/
COPY . /var/www/html/

# Install the PHP extension pdo_mysql for database connections
RUN docker-php-ext-install pdo_mysql

# Inform Docker that the container is listening on port 80 at runtime.
EXPOSE 80

# Enable Apache mod_rewrite for URL rewrite and setting up .htaccess
# Then restart Apache to apply changes.
RUN a2enmod rewrite && service apache2 restart
