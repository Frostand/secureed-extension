FROM php:8.2-cli

WORKDIR /app

# Copy the entire app directory
COPY app/SecureEd-1.0-master/app/ /app/

# Expose port 8000
EXPOSE 8000

# Initialize database then start the built-in server
CMD php src/startup.php && php -S 0.0.0.0:8000 -t public/
