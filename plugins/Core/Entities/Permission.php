<?php

namespace Labs\Core\Entities;

use Labs\Core\Entities\Traits\UuidModelTrait;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission
 * @package Labs\Core\Entities
 */
class Permission extends SpatiePermission implements \Spatie\Permission\Contracts\Permission
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
