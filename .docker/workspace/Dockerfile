ARG TARGET_PHP_VERSION=7.3
FROM php:${TARGET_PHP_VERSION}-cli

ARG SERVICE_DIR="./workspace"
COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ=UTC
RUN /tmp/scripts/set_timezone.sh ${TZ}

# add users
#ARG APP_USER=www-data
#ARG APP_GROUP=www-data
#ARG APP_USER_ID=1000
#ARG APP_GROUP_ID=1000

ARG APP_USER=www-data
ARG APP_GROUP=www-data
ARG APP_USER_ID=1000
ARG APP_GROUP_ID=1000


ARG WITH_XDEBUG

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN /tmp/scripts/install_software.sh

RUN apt-get install -yqq libicu-dev

RUN /tmp/scripts/install_php_extensions.sh

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
ARG APP_CODE_PATH="/var/www/"
WORKDIR "$APP_CODE_PATH"

# entrypoint
RUN mkdir -p /bin/docker-entrypoint/ \
 && cp /tmp/scripts/docker-entrypoint/* /bin/docker-entrypoint/ \
 && chmod +x -R /bin/docker-entrypoint/ \
;

RUN /tmp/scripts/cleanup.sh

# @see https://docs.docker.com/engine/examples/running_ssh_service/

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/composer

#Ligar/desligar xdebug#
COPY ./.shared/scripts/setXdebugOnOff.sh /usr/bin/
RUN chmod +x /usr/bin/setXdebugOnOff.sh

CMD /usr/sbin/sshd -D
ENTRYPOINT ["/bin/docker-entrypoint/resolve-docker-host-ip.sh"]

