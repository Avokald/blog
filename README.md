## About

[![Build Status](https://travis-ci.org/Avokald/blog.svg?branch=dev)](https://travis-ci.org/Avokald/blog)

Copy .env.example to .env file and insert different data if needed

Start up server:

```shell
(sudo) docker-compose up -d
```

On windows 10 change in webserver container /etc/nginx/nginx.conf file to use */etc/nginx/conf.d/app.conf* instead of 'include */etc/nginx/conf.d/*.conf*;'

In app container:

```shell
docker-compose exec app npm install

docker-compose exec app composer install

docker-compose exec app php artisan key:generate

docker-compose exec app php artisan migrate

docker-compose exec app php artisan db:seed
```

Run tests:

```shell
docker-compose exec app php vendor/phpunit/phpunit/phpunit
```

To display SwaggerUi on /api/documentation generate it by enabling auto generation (not for production) 
via .env L5_SWAGGER_GENERATE_ALWAYS=true or
```shell
php artisan l5-swagger:generate
```

Prometheus: localhost:9090/
Grafana: localhost:3020/
Node exporter grafana dashboard https://grafana.com/grafana/dashboards/1860
