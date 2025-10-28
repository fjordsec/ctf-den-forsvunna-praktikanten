FROM php:8.1-apache

# Enable mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Copy the website files to the container
COPY www/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80