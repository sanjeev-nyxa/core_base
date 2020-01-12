<?php
if (!function_exists('app_url')) {
    function app_url($route, $hash = true)
    {
        return env('FRONT_APP_URL') . $route;
    }
}