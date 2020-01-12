<?php

namespace Labs\Core\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Labs\Core\Events\Seeder\GetAppPermissions;
use Labs\Core\Events\UserRegistered;
use Labs\Core\Listeners\GetAppPermissionsListener;
use Labs\Core\Listeners\UserRegisteredListener;

/**
 * Class EventServiceProvider
 * @package Labs\Core\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        GetAppPermissions::class => [
            GetAppPermissionsListener::class,
        ],
        UserRegistered::class => [
            UserRegisteredListener::class
        ]
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
