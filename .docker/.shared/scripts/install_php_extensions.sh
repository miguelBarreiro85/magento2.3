#!/bin/sh

# add wget
apt-get update -yqq && apt-get -f install -yyq wget

# download helper script
# @see https://github.com/mlocati/docker-php-extension-installer/
wget -q -O /usr/local/bin/install-php-extensions https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions \
    || (echo "Failed while downloading php extension installer!"; exit 1)

# install extensions
chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
    opcache \
    xdebug \
    intl \
    pdo \
    pdo_mysql \
    gd \

echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "xdebug.remote_log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "xdebug.remote_connect_back=0" >>/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
echo "opcache.optimization_level=0x7FFFBBFF" >>/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \



