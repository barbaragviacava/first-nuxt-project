# LARAVEL 8

This server will run at port 8080.

## Build Setup
```bash
docker-compose up -d
docker exec -it laravel-back composer install
docker exec -it laravel-back artisan migrate --seed
```

## How to run tests (with PEST)
```bash
docker exec -it laravel-back ./vendor/bin/pest
docker exec -it laravel-back ./vendor/bin/pest --coverage
```