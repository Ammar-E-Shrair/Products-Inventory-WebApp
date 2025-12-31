FROM php:8.2-apache
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf && a2enconf servername
COPY src/ /var/www/html/
EXPOSE 80
