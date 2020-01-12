<?php

// Admin API Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin/blogs', 'namespace' => 'Labs\Blog\Http\Controllers\Admin'], function()
{
    Route::get('/', 'BlogController@index');
    Route::get('/{blog}', 'BlogController@show');
    Route::post('/', 'BlogController@store');
    Route::put('/{blog}', 'BlogController@update');
    Route::delete('/{blog}', 'BlogController@destroy');
});


// Front API Routes
Route::group(['middleware' => 'api', 'prefix' => 'blogs', 'namespace' => 'Labs\Blog\Http\Controllers\API'], function()
{
    Route::get('/', 'BlogController@index');
    Route::get('/{blog}', 'BlogController@show');
});