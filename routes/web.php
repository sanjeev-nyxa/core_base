<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('core::admin.app');
});

Route::get('dashboard', function () {
    return view('core::admin.app');
});


Route::get('test', function () {
    $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
//    dd($disk->allDirectories('unzipped'));
    foreach ($disk->allDirectories('unzipped') as $directory) {
       if(str_contains($directory, 'public')) {
           recurse_copy(storage_path("app/backups/".$directory), base_path('temp'));
           dd( $disk->allFiles($directory));

       }

    }

});



function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
