FROM php:8.2-apache
WORKDIR /var/www/html

COPY . $WORKDIR

#directory /var/www/wx_cache required by wx.php and others
USER 0

RUN mkdir -p /var/www//wx_cache

RUN chown www-data:www-data /var/www/wx_cache

EXPOSE 80

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
