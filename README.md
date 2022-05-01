
## About TestPorject

This is a Laravel test project.

## Prerequisite
To run this project you should have the following:
- PHP v7.* installed.
- MySql database engine.
- Composer installed: <a hred="https://getcomposer.org/download/">Install Here</a>

## How to run
- Clone the repository.
- Run command.
    ``Composer install``
- Create and configure the database.
- Run ``php artisan migrate:fresh --seed``
- Run ``php artisan serve``
- Now you are ready to call the APIs

## Available Endpoints
There are two endpoints: API, Web

### API Endpoint
```/api/v1/user/{id}/karma-position?num_users=10```

This API returns a json object that contains the requested result.

- **You should set request header /accept/ to "application/json" to get json response, otherwise you will get html response.**
- The query parameter (num_users) is optional. If not provided it is set to 5 by default.
- The path parameter (id) is the id of the user


### Web Endpoint
```/v1/user/{id}/karma-position?num_users=10```

This API returns a html web page that contains the requested result.

- The query parameter (num_users) is optional. If not provided it is set to 5 by default.
- The path parameter (id) is the id of the user

## Tests
There is an automated test for the API endpoint

To run the test: ``php artisan test --without-tty``
