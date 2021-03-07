#!/bin/bash
#por espaços entre os operadores senao da merda
if [[ "OFF" == $1 ]]
then
    # disable xdebug
    sed -i "s/zend_extension/;zend_extension/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
else
    sed -i "s/\;zend_extension/zend_extension/" /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
fi