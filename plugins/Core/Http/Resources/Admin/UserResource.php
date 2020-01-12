<?php

namespace Labs\Core\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\Resource;
use Labs\Core\Http\Resources\Admin\RoleResource;
use Labs\Core\Http\Resources\Participant\ParticipantResource;

/**
 * Class UserResource
 * @package Labs\Core\Http\Resource
 */
class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'avatar' => $this->avatar,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'lang' => $this->lang,
            'email' => $this->email,
            'gender' => $this->gender,
            'roles' => RoleResource::collection($this->roles),
            'mobile_number' => $this->mobile_number,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
        ];
    }
}
