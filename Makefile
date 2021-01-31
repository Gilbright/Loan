#!/bin/bash

CONTAINER_NAME = phenix-fpm
NETWORK_NAME = nirvana

setup:
	docker network create ${NETWORK_NAME} || true
	cp -n .env.docker .env || true
	docker-compose up -d

prepare:
	docker exec -it ${CONTAINER_NAME} composer install

cc:
	docker exec -it ${CONTAINER_NAME} bin/console cache:clear

clear-log:
	docker exec -it ${CONTAINER_NAME} rm -rf var/log/*

log:
	docker exec -it ${CONTAINER_NAME} tail -f var/log/dev.log

bash:
	docker exec -it ${CONTAINER_NAME} bash

