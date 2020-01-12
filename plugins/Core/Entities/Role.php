<?php

namespace Labs\Core\Entities;

use Labs\Core\Entities\Traits\UuidModelTrait;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role
 * @package Labs\Core\Entities
 */
class Role extends SpatieRole implements \Spatie\Permission\Contracts\Role
{
    use UuidModelTrait;
    /**
     * @var array
     */
    protected $fillable = ['name', 'guard_name'];
    /**
     * @var string
     */
    protected $guard_name = 'api';
}
