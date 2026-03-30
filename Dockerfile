# IranWar - Dockerfile
# Image PHP avec Apache et extensions nécessaires

FROM php:8.2-apache

# Installer les extensions PHP requises
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activer mod_rewrite pour les URLs propres
RUN a2enmod rewrite

# Configuration Apache pour autoriser .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . /var/www/html/

# Donner les permissions correctes
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/public/uploads

# Exposer le port 80
EXPOSE 80

# Healthcheck pour vérifier que le serveur répond
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

CMD ["apache2-foreground"]
