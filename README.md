# Test task "Pet Shop"

This is a test task project

## Setting up
First, you need to clone or download this git repository.

Then, to resolve all dependencies, in your console run 
```
composer install
```
and
```
npm install
```

Run migrations and seed the database by running
```
php artisan migrate --seed
```

Start a server with
```
php artisan serve
```
and run
```
npm run dev
```


## Testing API endpoints with Swagger docs
Open the app on this server; you will be automatically redirected to the [{base_url}/api-docs](http://127.0.0.1:8000/api-docs) page.
There, you will find a [Swagger](https://swagger.io/) documentation for all the api endpoints.

To test the routes which require authorization, you should login via on of the login endpoints (admin or user),
copy the authorization token from the response, click on the Authorize button, paste the token into the input field and
click Authorize. After that, you will be logged in until the token expires.

## Running Unit tests
Run
```
 php vendor/bin/phpunit
```
to run unit tests.
