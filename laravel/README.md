# LARAVEL 8

![Badge](https://img.shields.io/badge/coverage-97%25-green?style=flat-square)

<p>This project was made for study purposes</p>

## Technologies

- [x] Laravel 8
- [x] PHP 8.1
- [x] Localization
- [x] Docker
- [x] PEST

## :cake: Build Setup
```bash
docker-compose up -d
docker exec -it laravel-back composer install
docker exec -it laravel-back artisan migrate --seed
```

<p>:rocket: This server will run at port 8080 :rocket:</p>

## :muscle: How to run tests (with PEST)
```bash
docker exec -it laravel-back ./vendor/bin/pest
docker exec -it laravel-back ./vendor/bin/pest --coverage
```