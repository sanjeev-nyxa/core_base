<?php

namespace Labs\Core\Entities\Traits;

use Labs\Core\Entities\Site;

/**
 * Trait SiteableTrait
 * @package Labs\Core\Entities\Traits
 */
trait SiteableTrait
{
    /**
     * @TODO:: need to auto prepend the current model to the site() helper
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sites()
    {
        return $this->morphToMany(Site::class, 'siteable');
    }
}