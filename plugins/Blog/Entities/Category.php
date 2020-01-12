<?php

namespace Labs\Blog\Entities;

use Labs\Core\Entities\BaseModel;

/**
 * Class Category
 * @package Labs\Blog\Entities
 */
class Category extends BaseModel
{

    /**
     * @var array
     */
    protected $fillable = ["title", "description"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
