<?php

namespace Labs\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Labs\Core\Http\Requests\User\ChangePasswordRequest;
use Labs\Core\Http\Requests\User\ProfileUpdateRequest;
use Labs\Core\Http\Requests\User\UpdateAvatarRequest;
use Labs\Core\Http\Resources\UserResource;

/**
 * Class UserController
 * @package Labs\Core\Http\Controllers
 * @resource User
 *
 */
class UserController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/user",
     *     tags={"Authed User"},
     *     summary="Get User Data",
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource Response ",
     *          @SWG\Schema(ref="#/definitions/Core@UserResource")
     *      ),
     * ),
     * @param Request $request
     * @return UserResource
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * @SWG\Post(
     *     path="/user",
     *     tags={"Authed User"},
     *     summary="Update User Data",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ProfileUpdateRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource Response ",
     *          @SWG\Schema(ref="#/definitions/Core@UserResource")
     *      ),
     * ),
     * @param ProfileUpdateRequest $request
     * @return UserResource
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->update($request->input());
        return new UserResource($user);
    }

    /**
     * @SWG\Post(
     *     path="/update-password",
     *     tags={"Authed User"},
     *     summary="Update User Password",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ChangePasswordRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource Response ",
     *          @SWG\Schema(ref="#/definitions/Core@UserResource")
     *      ),
     * ),
     * @param ChangePasswordRequest $request
     * @return UserResource
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();
        $user->password = bcrypt($request->get('password'));
        $user->save();
        return new UserResource($user);
    }

    /**
     * @SWG\Put(
     *     path="/update-avatar",
     *     tags={"Authed User"},
     *     summary="Update User Avatar",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@UpdateAvatarRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource Response ",
     *          @SWG\Schema(ref="#/definitions/Core@UserResource")
     *      ),
     * ),
     *
     * The Value must be a valid Base64(png, jpg, jpeg, svg) string.
     * @param UpdateAvatarRequest $request
     * @return UserResource
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $user = $request->user();

        $user->getMedia('images')->map(function ($image) {
            $image->delete();
        });

        $media = $user->addMediaFromBase64($request->get('avatar'))
            ->usingFileName('avatar.png')
            ->toMediaCollection('images')->getUrl();
        $user->avatar = url($media);
        $user->save();

        return new UserResource($user);
    }


}