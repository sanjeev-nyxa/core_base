<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Database\Schema\Builder; // Import Builder where defaultStringLength method is defined

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Builder::defaultStringLength(191); // Update defaultStringLength
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }
}
