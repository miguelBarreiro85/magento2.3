FROM nginx:latest

ARG APP_USER="www-data"
ARG APP_GROUP="www-data"
ARG APP_USER_ID="1000"
ARG APP_GROUP_ID="1000"

COPY ./.shared/scripts/ /tmp/scripts/
RUN chmod +x -R /tmp/scripts/

# set timezone
ARG TZ
RUN /tmp/scripts/set_timezone.sh ${TZ}

RUN /tmp/scripts/create_user.sh ${APP_USER} ${APP_GROUP} ${APP_USER_ID} ${APP_GROUP_ID}

RUN rm -R /tmp/scripts/