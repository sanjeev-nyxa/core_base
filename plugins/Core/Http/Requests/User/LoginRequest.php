<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 * @package Labs\Core\Http\Requests\Participant
 * @SWG\Definition(
 *     definition="Core@LoginRequest",
 *     required={"email", "password"},
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
 * ),
 */
class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ];
    }
}