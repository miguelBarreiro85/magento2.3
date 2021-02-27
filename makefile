.PHONY: up
up:
	cd .docker && docker-compose up -d

.PHONY: down
down:
	cd .docker && docker-compose down -v

