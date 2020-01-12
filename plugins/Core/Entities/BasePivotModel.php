<?php

namespace Labs\Core\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Labs\Core\Entities\Traits\UuidModelTrait;


/**
 * Class BasePivotModel
 * @package Labs\Core\Entities
 */
class BasePivotModel extends Pivot
{
    use UuidModelTrait;

    protected $guard_name = 'api';
}