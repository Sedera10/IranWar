# IranWar - Dockerfile
# Image PHP avec Apache optimisé et extensions nécessaires

FROM php:8.2-apache

# Installer les extensions PHP requises
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Installer GD pour le traitement d'images (WebP, redimensionnement)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ====================================
# ETAPE 4: OPTIMISATION SERVEUR APACHE
# ====================================
# Activer les modules Apache nécessaires
RUN a2enmod rewrite \
    && a2enmod deflate \
    && a2enmod expires \
    && a2enmod headers \
    && a2enmod mime

# Configuration Apache pour autoriser .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Configuration Keep-Alive Apache
RUN echo '\n\
# Keep-Alive Configuration\n\
KeepAlive On\n\
MaxKeepAliveRequests 100\n\
KeepAliveTimeout 5\n\
' >> /etc/apache2/apache2.conf

# Configuration MPM pour meilleures performances
RUN echo '\n\
# MPM Configuration optimisée\n\
<IfModule mpm_prefork_module>\n\
    StartServers          5\n\
    MinSpareServers       5\n\
    MaxSpareServers      10\n\
    MaxRequestWorkers   150\n\
    MaxConnectionsPerChild 3000\n\
</IfModule>\n\
' >> /etc/apache2/apache2.conf

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
