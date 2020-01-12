<?php

namespace Labs\Core\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Labs\Core\Http\Resources\Admin\RoleResource;

/**
 * Class UserResource
 * @package Labs\Core\Http\Resource
 * @SWG\Definition(
 *     definition="Core@UserResource",
 *     @SWG\Property(property="id", description="UUID", type="string"),
 *     @SWG\Property(property="email", description="Email", type="string"),
 *     @SWG\Property(property="first_name", description="First Name", type="string"),
 *     @SWG\Property(property="last_name", description="Last Name", type="string"),
 *     @SWG\Property(property="user_id", description="User Identifier", type="string"),
 *     @SWG\Property(property="mobile_number", description="Mobile Number", type="string"),
 *     @SWG\Property(property="phone_number", description="Phone Number", type="string"),
 *     @SWG\Property(property="position", description="Position", type="string"),
 *     @SWG\Property(property="bio", description="Bio", type="string"),
 *     @SWG\Property(property="gender", description="Gender", type="string"),
 *     @SWG\Property(property="lang", description="Lang", type="string"),
 *     @SWG\Property(property="avatar", description="Avatar", type="string"),
 * ),
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
            'gender' => $this->gender,
            'email' => $this->email,
            'role' => new RoleResource($this->roles()->first()),
            'mobile_number' => $this->mobile_number,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
        ];
    }
}
