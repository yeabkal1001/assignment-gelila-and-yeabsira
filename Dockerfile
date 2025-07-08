# Use an official PHP image with Apache
FROM php:8.2-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy application files
COPY . /var/www/html/

# Set permissions (ensure www-data can write to images directory as per README)
RUN chown -R www-data:www-data /var/www/html/images \
    && chmod -R 775 /var/www/html/images \
    && a2enmod rewrite

# Expose port 80
EXPOSE 80
