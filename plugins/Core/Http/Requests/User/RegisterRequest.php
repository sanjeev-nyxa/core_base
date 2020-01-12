<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 * @package Labs\Core\Http\Requests\User
 * @SWG\Definition(
 *     definition="Core@RegisterRequest",
 *     required={"email", "password", "password_confirmation"},
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
 *     @SWG\Property(
 *          property="password_confirmation",
 *          type="password",
 *          description="Password Confirmation",
 *          example="123456789"
 *    ),
 * ),
 */
class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}