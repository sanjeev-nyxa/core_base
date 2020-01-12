<?php
Route::group(['middleware' => 'auth', 'prefix' => 'analytics', 'namespace' => 'Labs\Analytic\Http\Controllers'], function () {
    Route::get('', 'AnalyticController@index');

});
