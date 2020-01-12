<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin/translations'], function ($router) {

    $router->get('', 'TranslationController@index');

    $router->get('/{translate}', 'TranslationController@show');

    $router->post('', 'TranslationController@store');

    $router->put('/{translate}', 'TranslationController@update');

    $router->delete('/{translate}', 'TranslationController@destroy');
    $router->post('import', 'TranslationController@import');
});

Route::group(['middleware' => ['api']], function ($router) {
    $router->get('translations', 'TranslationController@index');
    $router->get('data-export/translations', 'Admin\TranslationController@export');
});

