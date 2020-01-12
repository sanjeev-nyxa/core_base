<?php

namespace Labs\Core\Entities\Traits;

use Labs\Core\Entities\Config;

/**
 * Trait ConfigableTrait
 * @package Labs\Core\Entities\Traits
 */
trait ConfigableTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function configs()
    {
        return $this->morphToMany(Config::class, 'configable');
    }
}