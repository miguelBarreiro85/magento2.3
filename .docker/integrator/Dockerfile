ARG TARGET_PHP_VERSION
ARG INSTALL_DIR

FROM php:7.4-fpm

LABEL maintainer="miguelbarreiro85@gmail.com"
LABEL php_version="7.4"
LABEL magento_version="2.4"
LABEL description="Magento 2.4 with PHP 7.4"

ENV COMPOSER_HOME /var/www/.composer/

ARG APP_USER="www-data"
ARG APP_GROUP="www-data"
ARG APP_USER_ID="1000"
ARG APP_GROUP_ID="1000"

ARG SERVICE_DIR="./integrator"

COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ
RUN /tmp/scripts/set_timezone.sh ${TZ}

ARG WITH_XDEBUG

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN /tmp/scripts/install_php_extensions.sh
RUN /tmp/scripts/install_software.sh

# set up ssh
RUN apt-get update -yqq && apt-get install -yqq openssh-server \
 && mkdir /var/run/sshd \
;

# add default public key to authorized_keys
USER ${APP_USER}
COPY ${SERVICE_DIR}/.ssh/insecure_id_rsa.pub /tmp/insecure_id_rsa.pub
RUN mkdir -p ~/.ssh \
 && cat /tmp/insecure_id_rsa.pub >> ~/.ssh/authorized_keys \
 && chown -R ${APP_USER}: ~/.ssh \
 && chmod 700 ~/.ssh \
 && chmod 600 ~/.ssh/authorized_keys \
;
USER root

# php config
COPY ./.shared/config/php/conf.d/*  /usr/local/etc/php/conf.d/


# workdir
ARG APP_CODE_PATH="/var/www/html"
WORKDIR "$APP_CODE_PATH"

RUN wget https://getcomposer.org/download/1.10.16/composer.phar && mv composer.phar /usr/local/bin/composer
COPY ./integrator/auth.json $COMPOSER_HOME

RUN chsh -s /bin/bash www-data

RUN chown -R www-data:www-data /var/www

COPY $SERVICE_DIR/install-magento /usr/local/bin/install-magento
RUN chmod +x /usr/local/bin/install-magento

# Add cron job
ADD $SERVICE_DIR/crontab /etc/cron.d/magento2-cron
RUN chmod 0644 /etc/cron.d/magento2-cron

COPY $SERVICE_DIR/scripts/ /usr/local/bin/
RUN chmod +x -R /usr/local/bin/

RUN touch /var/log/sorefoz_cron.log

ARG WITH_XDEBUG=false

RUN if [ $WITH_XDEBUG = "true" ] ; then \
        docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi ;
RUN docker-php-ext-install sockets

EXPOSE 9000