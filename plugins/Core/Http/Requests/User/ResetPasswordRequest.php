<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest
 * @package Labs\Core\Http\Requests\Participant
 * @SWG\Definition(
 *     definition="Core@ResetPasswordRequest",
 *     required={"token", "email", "password", "password_confirmation"},
 *     @SWG\Property(
 *          property="token",
 *          type="string",
 *          description="Email Token",
 *    ),
 *     @SWG\Property(
 *          property="email",
 *          type="email",
 *          description="Email",
 *          example="example@example.com"
 *    ),
 *    @SWG\Property(
 *          property="password",
 *          type="password",
 *          description="Password",
 *          example="123456789"
 *    ),
 *    @SWG\Property(
 *          property="password_confirmation",
 *          type="password",
 *          description="Password Confirmation",
 *          example="123456789"
 *    ),
 * ),
 */
class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'max:255', 'min:6'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}