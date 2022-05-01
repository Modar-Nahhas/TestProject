<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About TestPorject

This is a test project.

## How to run
- Clone the repository.
- Run command.
    ``Composer install``
- Create the database.
- Run ``php artisan migrate:fresh --seed``
- Run ``php artisan serve``
- Now you are ready to call the APIs

## Available Endpoints
There are two endpoints: API, Web

### API Endpoint
```/api/v1/user/{id}/karma-position?num_users=10```

This API returns a json object that contains the requested result.

- **You should set request header /accept/ to application/json to get json response, otherwise you will get html response.**
- The query parameter (num_users) is optional. If not provided it is set to 5 by default.
- The path parameter (id) is the id of the user


### Web Endpoint
```/v1/user/{id}/karma-position?num_users=10```

This API returns a html web page that contains the requested result.

- The query parameter (num_users) is optional. If not provided it is set to 5 by default.
- The path parameter (id) is the id of the user
