<?php

namespace Labs\Core\Listeners;

use Labs\Core\Events\Seeder\GetAppPermissions;

/**
 * Class GetAppPermissionsListener
 * @package Labs\Core\Listeners
 */
class GetAppPermissionsListener
{
    /**
     * Handle the event.
     *
     * @param GetAppPermissions $event
     * @return void
     */
    public function handle(GetAppPermissions $event)
    {
        $event->collection
            ->push('admin@dashboard')
            ->push('users')
            ->push('permission')
            ->push('translations')
            ->push('settings')
            ->push('logs')
            ->push('roles');
    }
}
