FROM php:8.2-apache
COPY ./api /var/www/html/
WORKDIR /var/www/html
EXPOSE 80
CMD ["apache2-foreground"]