<?php

// Admin API Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin/backups', 'namespace' => 'Labs\Backup\Http\Controllers\Admin'], function ($router) {
    $router->get('', 'BackupController@index');
    $router->post('create-new', 'BackupController@create');
    $router->match(['put', 'post'], 'upload', 'BackupController@upload');
    $router->post('download', 'BackupController@download');
    $router->post('restore', 'BackupController@restore');


//    Route::get('/{backup}', 'BackupController@show');
//    Route::put('/{backup}', 'BackupController@update');
    $router->delete('/{backup}', 'BackupController@destroy');
});
