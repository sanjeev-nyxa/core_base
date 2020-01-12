<?php

namespace Labs\Backup\Listeners;

use Labs\Core\Events\Seeder\GetAppPermissions;

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
            ->push('backups')
             // PERMISSIONS_HANDLER
         ;
    }
}
