## Установка

[![Build Status](https://travis-ci.org/Avokald/blog.svg?branch=dev)](https://travis-ci.org/Avokald/blog)

Установить и настроить Docker CE

Создать файл .env из .env.example

Начать сборку образов и запуск контейнеров:

```shell
(sudo) docker-compose up -d
```

На Windows 10 в контейнере webserver необходимо изменить файл /etc/nginx/nginx.conf и добавить */etc/nginx/conf.d/app.conf* вместо 'include */etc/nginx/conf.d/*.conf*;'

Для запуска программного сервера в контейнере app:

```shell
docker-compose exec app npm install

docker-compose exec app composer install

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan migrate

docker-compose exec app php artisan db:seed
```

Для запуска тестов:

```shell
docker-compose exec app php vendor/phpunit/phpunit/phpunit
```

Для автоматической генерации api.json файла при открытии /api/documentation можно изменить параметр в .env файле 
L5_SWAGGER_GENERATE_ALWAYS=true

Также можно запускать генерацию мануально 
```shell
php artisan l5-swagger:generate
```

Prometheus: localhost:9090/
Grafana: localhost:3020/
Node exporter grafana dashboard https://grafana.com/grafana/dashboards/1860
