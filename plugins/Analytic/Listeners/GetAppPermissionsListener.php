<?php

namespace Labs\Analytic\Listeners;

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
            // PERMISSIONS_HANDLER
         ;
    }
}
