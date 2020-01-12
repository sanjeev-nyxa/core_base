<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function ($router) {

    $router->get('users', 'UserController@index');

    $router->get('users/{user}', 'UserController@show');

    $router->post('users', 'UserController@store');

    $router->put('users/{user}', 'UserController@update');
    $router->put('users/{user}/profile', 'UserController@updateProfile');

    $router->delete('users/{user}', 'UserController@destroy');

    $router->get('roles', 'RoleController@index');

    $router->get('roles/{role}', 'RoleController@show');

    $router->post('roles', 'RoleController@store');

    $router->put('roles/{role}', 'RoleController@update');
    $router->post('roles/{role}/permissions', 'RoleController@updatePermissions');

    $router->delete('roles/{role}', 'RoleController@destroy');


    $router->get('permissions', 'PermissionController@index');
});

Route::group(['middleware' => ['auth']], function ($router) {
    $router->get('user', 'UserController@me');
    $router->post('user', 'UserController@updateProfile');
    $router->post('user/update-password', 'UserController@updatePassword');
    $router->put('user/update-avatar', 'UserController@updateAvatar');


    $router->get('notifications', 'NotificationController@all');
    $router->get('notifications/unread', 'NotificationController@unread');
    $router->get('notifications/mark-as-read', 'NotificationController@markAsRead');

});
