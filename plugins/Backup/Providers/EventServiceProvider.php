<?php

namespace Labs\Backup\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Labs\Core\Events\Seeder\GetAppPermissions;

/**
 * Class EventServiceProvider
 * @package Labs\Backup\Providers
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
            \Labs\Backup\Listeners\GetAppPermissionsListener::class,
        ],
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
