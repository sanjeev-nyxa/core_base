<?php

namespace Labs\Blog\Entities;

use Labs\Core\Entities\BaseModel;

/**
 * Class Blog
 * @package Labs\Blog\Entities
 */
class Blog extends BaseModel
{

    /**
     * @var array
     */
    protected $fillable = ["title", "description", "content", "category_id"];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
