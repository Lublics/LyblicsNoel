FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_sqlite \
    && a2enmod rewrite expires headers

COPY . /var/www/html/

RUN mkdir -p /var/www/html/data /var/www/html/images/uploads \
    && chown -R www-data:www-data /var/www/html/data /var/www/html/images/uploads \
    && chmod -R 775 /var/www/html/data /var/www/html/images/uploads

RUN { \
        echo '<Directory /var/www/html>'; \
        echo '    AllowOverride All'; \
        echo '    Require all granted'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/app.conf \
    && a2enconf app

EXPOSE 80
