<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Labs\Core\Http\Requests\User\LoginRequest;
use Labs\Core\Http\Resources\AuthenticationResource;
use Labs\Core\Support\Traits\ApiResponses;


/**
 * Class LoginController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 *
 */
class LoginController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | Login Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

    use AuthenticatesUsers, ApiResponses;

    /**
     * @SWG\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="User Login",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@LoginRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Authentication Response ",
     *          @SWG\Schema(ref="#/definitions/Core@AuthenticationResource")
     *      ),
     * ),
     * @param LoginRequest $request
     * @return AuthenticationResource
     */
    public function login(LoginRequest $request)
    {
        // If the class is using the Throttles Login trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $user = User::query()->where('email', $request->get('email'))->first();

        // Send the response after the user was authenticated.
        if ($user && Hash::check($request->get('password'), $user->password)) {
            $this->clearLoginAttempts($request);

            // fire event new user logged in.

            // remove the old token.
            $user->tokens()->where('name', $request->header('Participant-Agent'))->delete();
            return new AuthenticationResource($user);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$lockedOut) {
            $this->incrementLoginAttempts($request);
        }
        return response()->json([
            'message' => trans('auth.failed')
        ], 401);
    }

    /**
     * Logout User.
     * When User Logout We Will Log him out and destroy the token.
     * **Method: Labs\Core\Http\Controllers\Auth\LoginController@logout **
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return $this->respondWithData(true);
        }
        return $this->respondWithData($request->user()->tokens()->where('name', $request->header('Participant-Agent'))->delete());
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLockoutResponse($request)
    {
        $this->fireLockoutEvent($request);

        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = trans('auth.throttle', ['seconds' => $seconds]);

        return $this->respondBadRequest($message);
    }
}