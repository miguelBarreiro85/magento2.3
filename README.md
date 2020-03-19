# magento2.3
nginx + phpfmm

This project tries to setup a local docker environment with nginx php7.2-fpm mysql5.6 for magento 2.3

The nginx and php share the docker volume that holds the magento backend code

To keep magento folders with in IDE it is necessary to enter the container with www-data user and 
create the magento project.

composer create-project --ignore-platform-reqs --repository=https://repo.magento.com/ magento/project-community-edition .





