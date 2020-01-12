<?php

namespace Labs\Core\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;

class TranslationResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
