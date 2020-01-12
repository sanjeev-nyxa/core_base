<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Labs\Core\Http\Requests\User\ForgotPasswordSMSRequest;
use Labs\Core\Notifications\SendSMSResetPasswordNotification;
use Labs\Core\Support\Traits\ApiResponses;

/**
 * Class ForgotPasswordController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 *
 */
class ForgotPasswordSMSController extends Controller
{

    /*
       |--------------------------------------------------------------------------
       | Password Reset Controller
       |--------------------------------------------------------------------------
       |
       | This controller is responsible for handling password reset emails and
       | includes a trait which assists in sending these notifications from
       | your application to your users. Feel free to explore this trait.
       |
       */

    use  ApiResponses;

    /**
     * @SWG\Post(
     *     path="/forgot-password-sms",
     *     tags={"Auth"},
     *     summary="User Forgot Password (SMS)",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ForgotPasswordSMSRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Your Ping Code Has Been Sent Successfully To Your Mobile Number",
     *      ),
     * ),
     * @param ForgotPasswordSMSRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ForgotPasswordSMSRequest $request)
    {
        $user = User::where('mobile_number', $request->get('mobile_number'))->first();
        if ($user) {
            $mobile_code = rand(1000, 9999);
            $user->mobile_number_code = $mobile_code;

            $user->save();

            $user->notify(new SendSMSResetPasswordNotification($mobile_code));

            return $this->respondDataCreated("Your Ping Code Has Been Sent Successfully To :" . $user->mobile_number);
        }


        return $this->respondBadRequest("Oops, Looks like something went wrong please check your mobile number or try again later");
    }
}