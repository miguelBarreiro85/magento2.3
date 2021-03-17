.PHONY: up
up:
	cd .docker && docker-compose up -d

.PHONY: stop
stop:
	cd .docker && docker-compose stop

.PHONY: down
down:
	cd .docker && docker-compose down

.PHONY: build
build:
	cd .docker && docker-compose build

.PHONY: db_backup
db_backup:
	docker exec docker_db_magento_1 /usr/bin/mysqldump -u magento --password=magento magento > db_backups/magento.sql

.PHONY: db_restore
db_restore:
	cat db_backups/contabo.sql | docker exec -i docker_db_magento_1 /usr/bin/mysql -u magento --password=magento magento

.PHONY: images_bakcup
images_bakcup:
	tar -zcvf images_backup/img_bak.tar.gz --exclude="cache/*" magento2/pub/media/catalog/product/

