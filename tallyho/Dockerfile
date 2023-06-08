# FROM php:apache
# COPY my-apache.conf /usr/local/apache2/conf/httpd.conf
# RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql
# # COPY yii-framework.tar.gz /var/www/html/
# # RUN tar -xvzf /var/www/html/yii-framework.tar.gz -C /var/www/html/
# RUN chmod 755 /var/www/
# RUN chown -R www-data:www-data /var/www/
# RUN apt-get update && apt-get upgrade -y
FROM php:apache

# Install the mysqli extension
RUN docker-php-ext-install mysqli && \
    docker-php-ext-enable mysqli


# Set the document root
ENV APACHE_DOCUMENT_ROOT /var/www/

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy your PHP application files to the container
COPY . /var/www/

# Set the correct permissions for the files
RUN chown -R www-data:www-data /var/www/

