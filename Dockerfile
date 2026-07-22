FROM php:8.2-fpm

WORKDIR /var/www/html

# The PHP 8.2 FPM image already includes the SQLite3 and PDO SQLite modules
# used by this project, so no extra package manager step is needed.

COPY app/SecureEd-1.0-master/app/ /var/www/html/

RUN mkdir -p /var/www/html/db /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/db /var/www/html/uploads /var/www/html/resources

# Reset the classroom database once when the PHP container starts, then hand
# requests to PHP-FPM. Nginx is the public-facing service in docker-compose.yml.
CMD ["sh", "-c", "php src/startup.php && touch resources/tmp.txt && chown -R www-data:www-data db uploads resources/tmp.txt && exec php-fpm"]
