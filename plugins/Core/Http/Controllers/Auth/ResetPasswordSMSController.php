<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Labs\Core\Http\Requests\User\ConfirmPinPasswordRequest;
use Labs\Core\Http\Requests\User\ResetPasswordSMSRequest;
use Labs\Core\Http\Resources\AuthenticationResource;
use Labs\Core\Support\Traits\ApiResponses;

/**
 * Class ResetPasswordController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 * **Method: Labs\Core\Http\Controllers\Auth\ResetPasswordSMSController **
 */
class ResetPasswordSMSController extends  Controller
{
    use SendsPasswordResetEmails;
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

    use ApiResponses;

    /**
     * @SWG\Post(
     *     path="/reset-password-sms",
     *     tags={"Auth"},
     *     summary="User Reset Password (SMS)",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ConfirmPinPasswordRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Your Ping Code Has Been Sent Successfully To Your Mobile Number",
     *      ),
     * ),
     * @param ConfirmPinPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse|AuthenticationResource
     */
    public function confirmPin(ConfirmPinPasswordRequest $request)
    {
        $user = User::where('mobile_number', $request->get('mobile_number'))
            ->where('mobile_number_code', $request->get('mobile_number_code'))
            ->first();
        if ($user) {
            return new AuthenticationResource($user);
        }

        return $this->respondBadRequest("Oops, Looks like something went wrong please check your mobile number or try again later");
    }

    /**
     * Reset Participant Password SMS.
     * **Method: Labs\Core\Http\Controllers\Auth\ResetPasswordSMSController@reset **
     * @param  ResetPasswordSMSRequest $request
     * @return \Illuminate\Http\JsonResponse|AuthenticationResource
     */
    public function reset(ResetPasswordSMSRequest $request)
    {
        $user = User::where('id', $request->get('token'))
            ->where('mobile_number', $request->get('mobile_number'))
            ->where('mobile_number_code', $request->get('mobile_number_code'))
            ->first();

        if($user) {
            $user->forceFill([
                'password' => bcrypt($request->get('password')),
                'mobile_number_code' => null
            ])->save();
            // remove the old token.
            $user->tokens()->where('name', $request->header('Participant-Agent'))->delete();
            return new AuthenticationResource($user);
        }
        return $this->respondBadRequest("Oops, Looks like something went wrong please check your mobile number or try again later");
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
        ])->save();;
    }

}