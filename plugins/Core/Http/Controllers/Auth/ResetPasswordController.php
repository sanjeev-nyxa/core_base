<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Labs\Core\Http\Requests\User\ResetPasswordRequest;
use Labs\Core\Http\Resources\AuthenticationResource;
use Labs\Core\Support\Traits\ApiResponses;

/**
 * Class ResetPasswordController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 *
 */
class ResetPasswordController extends Controller
{
    /**
     * @var
     */
    protected $user;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, ApiResponses;

    /**
     * @SWG\Post(
     *     path="/reset-password",
     *     tags={"Auth"},
     *     summary="User Reset Password",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ResetPasswordRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Authentication Response ",
     *          @SWG\Schema(ref="#/definitions/Core@AuthenticationResource")
     *      ),
     * ),
     * @param  ResetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse|AuthenticationResource
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset($request->input(), function ($user, $password) {
            $this->resetPassword($user, $password);
        });


        // If the password was successfully reset, we return success response message.
        if ($response == Password::PASSWORD_RESET) {
            //  clean user tokens
            $this->user->tokens()->delete();

            $this->user->tokens()->where('name', $request->header('User-Agent'))->delete();
            return new AuthenticationResource($this->user);
        }

        return $this->respondBadRequest(trans($response));
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->user = $user;
        return $user->forceFill([
            'password' => bcrypt($password)
        ])->save();
    }

}