init: docker-down-clear docker-pull docker-build-pull docker-up app-init
down: docker-down-clear
lint: app-lint
test: app-test

docker-up:
	docker-compose up -d

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build-pull:
	docker-compose build --pull

app-init: composer-install

composer-install:
	docker-compose run --rm php-cli composer install

composer-update:
	docker-compose run --rm php-cli composer update

app-lint:
	docker-compose run --rm php-cli composer lint

app-test:
	docker-compose run --rm php-cli composer test
