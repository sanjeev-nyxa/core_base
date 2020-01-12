<?php

namespace Labs\Core\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Labs\Core\Support\Traits\ApiResponses;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Labs\Core\Http\Requests\User\ForgotPasswordRequest;

/**
 * Class ForgotPasswordController
 * @package Labs\Core\Http\Controllers\Auth
 * @resource Authentication
 *
 */
class ForgotPasswordController extends Controller
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

    use SendsPasswordResetEmails, ApiResponses;

    /**
     * @SWG\Post(
     *     path="/forgot-password",
     *     tags={"Auth"},
     *     summary="User Forgot Password",
     *     @SWG\Parameter(
     *          name="user",
     *          in="body",
     *          required=true,
     *          type="string",
     *          schema={"$ref": "#/definitions/Core@ForgotPasswordRequest"},
     * 		),
     *     @SWG\Response(
     *          response=200,
     *          description="Password Reset Message",
     *      ),
     * ),
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ForgotPasswordRequest $request)
    {
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        if ($response === Password::RESET_LINK_SENT) {
            return $this->respondWithData(trans($response));
        }

        return $this->respondBadRequest(trans($response));
    }
}