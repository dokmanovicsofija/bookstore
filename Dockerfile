# Koristi zvaničnu PHP sliku kao bazu
FROM php:8.3-apache

# Instaliraj potrebne PHP ekstenzije
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Postavi radni direktorijum u kontejneru
WORKDIR /var/www/html

# Kopiraj sve datoteke iz lokalnog direktorijuma u radni direktorijum kontejnera
COPY . /var/www/html

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install project dependencies
RUN composer install

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Postavi Apache konfiguraciju za direktorijum
RUN echo "<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/bookstore.conf && \
    a2enconf bookstore

# Postavi odgovarajuće dozvole
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Izloži port 80
EXPOSE 80

# Startuj Apache server
CMD ["apache2-foreground"]