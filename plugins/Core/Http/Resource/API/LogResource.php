<?php

namespace Labs\Core\Http\Resource\API;

use Illuminate\Http\Resources\Json\Resource;

class LogResource extends Resource
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
