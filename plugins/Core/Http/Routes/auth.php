<?php
Route::group(['middleware' => ['api'], 'namespace' => 'Auth'], function ($router) {
    Broadcast::routes(['middleware' => 'auth:api']);
    $router->post('register', 'RegisterController@register');
    $router->post('login', 'LoginController@login');
    $router->get('logout', 'LoginController@logout');

    $router->post('forgot-password', 'ForgotPasswordController@reset');
    $router->post('forgot-password-sms', 'ForgotPasswordSMSController@reset');

    $router->post('reset-password/confirm-pin', 'ResetPasswordSMSController@confirmPin');
    $router->post('reset-password-sms', 'ResetPasswordSMSController@reset');

    $router->post('reset-password', 'ResetPasswordController@reset');

});

