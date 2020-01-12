<?php

namespace Labs\Core\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class AuthenticationResource
 * @package Labs\Core\Http\Resources
 * @SWG\Definition(
 *     definition="Core@AuthenticationResource",
 *     @SWG\Property(
 *          property="token",
 *          type="string",
 *          description="Bearer Token",
 *    ),
 *    @SWG\Property(
 *          property="user",
 *          type="object",
 *          description="UserResource",
 *    ),
 * ),
 */
class AuthenticationResource extends Resource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return array(
            'token' => $this->createToken($request->header('User-Agent'))->accessToken,
            'user' => new UserResource($this)
        );
    }
}