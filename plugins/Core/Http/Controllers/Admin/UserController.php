<?php namespace Labs\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Labs\Core\Events\UserRegistered;
use Labs\Core\Http\Requests\Admin\User as UserRequests;
use Labs\Core\Http\Resources\Admin\UserResource;

/**
 * Class UserController
 * @package Labs\Core\Http\Controllers
 * @resource Admin Users
 *
 */
class UserController extends Controller
{
    /**
     * UserController constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @SWG\Get(
     *     path="/admin/users",
     *     tags={"Admin Users"},
     *     summary="Get Users List",
     *     @SWG\Response(
     *          response=200,
     *          description="ORACLE Fluent Query Response.",
     *      ),
     * ),
     * @param UserRequests\UserShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(UserRequests\UserShowRequest $request)
    {
        return datatables()->eloquent($this->model->with('roles'))->toJson();
    }

    /**
     * @SWG\Get(
     *     path="/admin/users/{user}",
     *     tags={"Admin Users"},
     *     summary="Get User",
     *     @SWG\Parameter(
     *          name="user",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource.",
     *      ),
     * ),
     * @param UserRequests\UserShowRequest $request
     * @param User $user
     * @return UserResource
     */
    public function show(UserRequests\UserShowRequest $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @SWG\Post(
     *     path="/admin/users",
     *     tags={"Admin Users"},
     *     summary="Create New User",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminUserStoreRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource.",
     *      ),
     * ),
     * @param  UserRequests\UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserRequests\UserStoreRequest $request)
    {
        $model = $this->storeUserData($request);

        $this->updateUserRoles($request, $model);

        event(new UserRegistered($model));

        return new UserResource($model);
    }

    /**
     * @SWG\Put(
     *     path="/admin/users/{user}",
     *     tags={"Admin Users"},
     *     summary="Update User",
     *     @SWG\Parameter(
     *          name="user",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminUserUpdateRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource.",
     *      ),
     * ),
     * @param  User $user
     * @param  UserRequests\UserUpdateRequest $request
     * @return UserResource
     */
    public function update(UserRequests\UserUpdateRequest $request, User $user)
    {
        $user->update($request->input());

        $user->roles()->sync(collect($request->get('roles'))->pluck('id'));

        return new UserResource($user);
    }

    /**
     *
     * @SWG\Put(
     *     path="/admin/users/{user}/profile",
     *     tags={"Admin Users"},
     *     summary="Update User Profile",
     *     @SWG\Parameter(
     *          name="user",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@AdminUserProfileUpdateRequest"},
     *        ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource.",
     *      ),
     * ),
     * @param UserRequests\UserProfileUpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    public function updateProfile(UserRequests\UserProfileUpdateRequest $request, User $user)
    {
        $user->update($request->input());
        return new UserResource($user);
    }

    /**
     * @SWG\Delete(
     *     path="/admin/users/{user}",
     *     tags={"Admin Users"},
     *     summary="Delete User",
     *     @SWG\Parameter(
     *          name="user",
     *          in="path",
     *          description="UUID",
     *          required=true,
     *          type="string"
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="UserResource.",
     *      ),
     * ),
     * @param UserRequests\UserDestroyRequest $request
     * @param User $user
     * @return UserResource
     * @throws \Exception
     */
    public function destroy(UserRequests\UserDestroyRequest $request, User $user)
    {
        $user->delete();

        return new UserResource($user);
    }

    /**
     * @param UserRequests\UserStoreRequest $request
     * @return mixed
     */
    protected function storeUserData(UserRequests\UserStoreRequest $request)
    {
        $model = $this->model->create(array_merge(
            $request->input(),
            ['user_id' => $this->getUserId(), 'password' => bcrypt($request->get('password'))]
        ));
        return $model;
    }

    /**
     * @param UserRequests\UserStoreRequest $request
     * @param $model
     */
    protected function updateUserRoles(UserRequests\UserStoreRequest $request, $model): void
    {
        collect($request->get('roles'))->map(function ($role) use ($model) {
            $model->assignRole($role['name']);
        });
    }

    /**
     * @return string
     */
    protected function getUserId(): string
    {
        if (User::all()->count()) {
            $latest_id = (int)User::orderByDesc('user_id')->first()->user_id;
        } else {
            $latest_id = 0;
        }
        return str_pad(($latest_id + 1), 4, "0", STR_PAD_LEFT);
    }
}