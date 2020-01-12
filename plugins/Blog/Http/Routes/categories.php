<?php

// Admin API Routes
Route::group(['middleware' => 'auth', 'prefix' => 'admin/categories', 'namespace' => 'Labs\Blog\Http\Controllers\Admin'], function()
{
    Route::get('/', 'CategoryController@index');
    Route::get('/{category}', 'CategoryController@show');
    Route::post('/', 'CategoryController@store');
    Route::put('/{category}', 'CategoryController@update');
    Route::delete('/{category}', 'CategoryController@destroy');
});


// Front API Routes
Route::group(['middleware' => 'api', 'prefix' => 'categories', 'namespace' => 'Labs\Blog\Http\Controllers\API'], function()
{
    Route::get('/', 'CategoryController@index');
    Route::get('/{category}', 'CategoryController@show');
});