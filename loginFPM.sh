if [ "$#" -eq 0 ]; then
  docker exec -it docker_php_magento_1 /bin/bash
fi
docker exec -u www-data -it docker_php_magento_1 /bin/bash
