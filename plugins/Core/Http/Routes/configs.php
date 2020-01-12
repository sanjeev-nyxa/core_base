<?php

// Admin API Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin/configs', 'namespace' => 'Admin'], function () {
    Route::get('/', 'ConfigController@index');
    Route::post('/images', 'ConfigController@images');
    Route::post('/', 'ConfigController@store');
});


Route::group(['prefix' => 'configs'], function () {
    Route::get('/', 'ConfigController@index');
});
