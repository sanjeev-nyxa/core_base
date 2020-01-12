<?php

namespace Labs\Core\Entities;

use Labs\Core\Entities\Traits\UuidModelTrait;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

/**
 * Class Media
 * @package Labs\Core\Entities
 */
class Media extends SpatieMedia
{
    use UuidModelTrait;

    protected $guard_name = 'api';

}
