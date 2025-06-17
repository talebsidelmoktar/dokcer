FROM wordpress:6.4-apache

# Install PostgreSQL support and other dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-install mysqli pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Install PostgreSQL for WordPress plugin
RUN cd /tmp && \
    wget https://downloads.wordpress.org/plugin/postgresql-for-wordpress.zip && \
    unzip postgresql-for-wordpress.zip && \
    mv postgresql-for-wordpress /var/www/html/wp-content/plugins/ && \
    rm postgresql-for-wordpress.zip

# Copy custom configuration
COPY wp-config.php /var/www/html/wp-config.php
COPY .htaccess /var/www/html/.htaccess

# Copy wp-content if it exists
COPY wp-content/ /var/www/html/wp-content/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
RUN chmod 644 /var/www/html/wp-config.php

# Enable Apache modules
RUN a2enmod rewrite
RUN a2enmod headers

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
