# HardHat App

## Requirements
[Setup Laravel](https://laravel.com/docs/5.6)

|Library|Preffered Version|
|-|-|-|
|PHP|7.1^|
|node|9.*|
|npm|6.*|
|yarn|1.6^|
|redis-server|4.*|
|laravel-echo-server|1.3.*|


## Project Setup
`composer install`

`yarn install`

`cp .env.example .env`

Create new database Then

`php artisan zix:install`

`yarn dev`

To Serve The App Locally

`php artisan serve`

`laravel-echo-server start`

## Project Structure

Note: this is a modular app, we split the app logic into couple of modules in the plugins folder
```
app
bootstrap
config
database
plugins
|
|______Core (the core of the app)
|      |____ Assets
|      |     |____admin (contains all the core ui logic)
|      |          |_____ bootstrap (will load all the required packages)
|      |          |_____ components (basic components: header, footer sidebar, breadcrumbs)
|      |          |_____ lang (contains the multilang logic)
|      |          |_____ libraries (all he heavy components: data-table)
|      |          |_____ pages (contain all our pages views)
|      |          |_____ plugins (shared plugins accross the app: $http, $echo)
|      |          |_____ router (the router logic)
|      |          |_____ store (vuex store)
|      |          |_____ app.blade.php (the base admin template for laravel)
|      |          |_____ App.js
|      |          |_____ boot.js
|      |          |_____ main.js
|      |
|      |
|      |____ Console
|      |    |__ Commands (The shared Commands accross our plugins
|      |    |__ Generators (command helpers
|      |
|      |____ Database
|      |    |___ Migrations (all the core migrations)
|      |    |___ Seeds (Core DB Seeders)
|      |
|      |____ Events
|      |    |___ Analytics (Related Event To Anaylyser Plugins to track user actions)
|      |    |___ Seeders (Event Will be runned during the seed process)
|      |
|      |____ Http
|      |    |____ Controllers
|      |    |    |___ Admin (All Admin Logic Controllers)
|      |    |    |___ Auth (API Login, Register, Reset Password Logic)
|      |    |    |___ Coach (All Coach Logic Controllers)
|      |    |    |___ Participant (All Participant Logic Controller)
|      |    |
|      |    |____ Middleware
|      |    |____ Requests
|      |    |    |____ Admin (Admin Requests Validator + Permissions)
|      |    |    |____ User
|      |    |
|      |    |____ Resources (API response date Transformers)
|      |    |____ Routes (API Routes)
|      |
|      |____ Libraries (Core Helpers)
|      |
|      |____ Listeners (Event Listeners)
|      |
|      |____ Models
|      |
|      |____ Notifications
|      |
|      |____ Providers
|
|
|______ Session (Same Structure as core but with all related logic to sessions functionality)
|
|______ Assessment (Same Structure as core but with all related logic to assessments functionality)
|
|______ Resource (Same Structure as core but with all related logic to resources functionality)
|
|______ Chat (Same Structure as core but with all related logic to chat functionality)
|
|______ Analyser (Same Structure as core but with all related logic to analyser functionality)
|
|______ PluginBuilder (Contains Some helpers for the core to generate the models, notifications, events.. and create nw plugins)
|
|
|
|
|
public
resources
routes
storage

```

## Used Packages
- [Laravel Passport](https://laravel.com/docs/5.6/passport)
- [Laravel Excel](https://laravel-excel.maatwebsite.nl/)
- [Predis](https://packagist.org/packages/predis/predis)
- [Laravel CSV Importer](https://github.com/RomaGilyov/laravel-csv-importer)
- [Laravel Media Library](https://github.com/spatie/laravel-medialibrary)
- [Laravel Permission](https://github.com/spatie/laravel-permission)
- [Laravel Translatable](https://github.com/spatie/laravel-translatable)
- [Databale API](https://github.com/yajra/laravel-datatables)
- [Laravel API Documentation Generator](https://github.com/mpociot/laravel-apidoc-generator)

{{--@if($showPostmanCollectionButton)--}}
{{--[Get Postman Collection]({{url($outputPath.'/collection.json')}})--}}
{{--@endif--}}