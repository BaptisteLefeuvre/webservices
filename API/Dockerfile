FROM php:7-apache

COPY config.conf /etc/apache2/sites-available/000-default.conf
COPY start-apache /usr/local/bin
RUN a2enmod rewrite

# Copy application source
COPY serveur /var/www/
RUN chown -R www-data:www-data /var/www

CMD ["start-apache"]