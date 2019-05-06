FROM node:10.15-stretch

RUN apt-get update \
    && apt-get install -y python curl build-essential
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" |  tee /etc/apt/sources.list.d/yarn.list
RUN apt-get install -y apt-transport-https ca-certificates
RUN apt install -y yarn \
    && npm install -g node-gyp

RUN git clone https://github.com/magento-research/pwa-studio.git pwa-studio
WORKDIR pwa-studio
RUN yarn install
COPY venia.env /pwa-studio/packages/venia-concept/.env
COPY run_script /usr/bin/run_venia.sh
RUN chmod +x /usr/bin/run_venia.sh

EXPOSE 8080