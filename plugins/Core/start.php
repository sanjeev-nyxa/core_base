<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Register Namespaces and Routes
|--------------------------------------------------------------------------
|
| When your module starts, this file is executed automatically. By default
| it will only load the module's route file. However, you can expand on
| it to load anything else from the module, such as a class or view.
|
*/

if (!app()->routesAreCached()) {
    Route::group([
        'namespace' => 'Labs\Core\Http\Controllers',
        'prefix' => env('API_PREFIX')
    ], function () {

        $files = File::files(__DIR__ . '/Http/Routes');

        foreach ($files as $file) {
            File::getRequire($file);
        }
    });

}
