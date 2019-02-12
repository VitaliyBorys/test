#!/bin/bash
sudo sysctl -w vm.max_map_count=262144
docker-compose up --build -d
## To sleep for 5 seconds: ###
sleep 5
docker-compose exec php-cli composer install
docker-compose exec php-cli php artisan key:generate
docker-compose exec php-cli php vendor/bin/phpunit
sleep 3
docker-compose exec php-cli php artisan migrate:refresh --seed
docker-compose exec node npm install
docker-compose exec node npm run dev
