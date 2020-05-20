## About

[![Build Status](https://travis-ci.org/Avokald/blog.svg?branch=dev)](https://travis-ci.org/Avokald/blog)



To start up server:

```shell
(sudo) docker-compose up -d
```


To display SwaggerUi on /api/documentation generate it by enabling auto generation (not for production) 
via .env L5_SWAGGER_GENERATE_ALWAYS=true or
```shell
php artisan l5-swagger:generate
```