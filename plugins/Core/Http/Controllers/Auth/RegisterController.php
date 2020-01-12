<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Validation\Validator;
use Labs\Core\Events\UserRegistered;
use Labs\Core\Http\Requests\User\RegisterRequest;
use Labs\Core\Http\Resources\AuthenticationResource;


/**
 * Class RegisterController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 *
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * @var User
     */
    public $user;

    /**
     * RegisterController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @SWG\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="User Register",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@RegisterRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Authentication Response ",
     *          @SWG\Schema(ref="#/definitions/Core@AuthenticationResource")
     *      ),
     * ),
     * @param RegisterRequest $request
     * @return AuthenticationResource
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->user->create([
            'user_id' => $this->getUserId(),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        event(new UserRegistered($user));

        return new AuthenticationResource($user);

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