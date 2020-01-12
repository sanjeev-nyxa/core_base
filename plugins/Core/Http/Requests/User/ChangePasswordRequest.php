<?php

namespace Labs\Core\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserChangePasswordRequest
 * @package Labs\Core\Http\Requests\User
 * @SWG\Definition(
 *     definition="Core@ChangePasswordRequest",
 *     required={"old_password", "password", "password_confirmation"},
 *     @SWG\Property(
 *          property="old_password",
 *          type="password",
 *          description="Old Password",
 *          example="987654321"
 *     ),
 *     @SWG\Property(
 *          property="password",
 *          type="password",
 *          description="Password",
 *          example="123456789"
 *     ),
 *     @SWG\Property(
 *          property="password_confirmation",
 *          type="password",
 *          description="Password Confirmation",
 *          example="123456789"
 *     ),
 * ),
 */
class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'passcheck'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}
