# ROHM App

## Requirements  

php7.1^^, 
predis-server,
laravel-echo-server


## Project Setup
`composer install`

`yarn install`

`cp .env.example .env`

Create new database Then

`php artisan module:migrate`

`php artisan module:seed`

`php artisan passport:install`

`yarn dev`

To Serve The App Locally

`php artisan serve`

`cp laravel-echo-server-local.json laravel-echo-server.json`

`laravel-echo-server start`