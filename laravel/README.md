# LARAVEL 8

![Badge](https://img.shields.io/badge/coverage-96.6%25-green?style=flat-square)

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
docker exec -it laravel-back artisan storage:link
```

<p>:rocket: This server will run at port 8080 :rocket:</p>

## :muscle: How to run tests (with PEST)
```bash
docker exec -it laravel-back touch ./database/test.sqlite
docker exec -it laravel-back ./vendor/bin/pest
docker exec -it laravel-back ./vendor/bin/pest --coverage
```

## Author
<p>Made with :sparkling_heart: by Barbara Viacava</p>
<img src="https://avatars.githubusercontent.com/u/25326917?v=4" style="width:100px;" alt="My avatar">