<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ForgotPasswordRequest
 * @package Labs\Core\Http\Requests\Participant
 * @SWG\Definition(
 *     definition="Core@ForgotPasswordRequest",
 *     required={"email"},
 *     @SWG\Property(
 *          property="email",
 *          type="email",
 *          description="Email",
 *          example="example@example.com"
 *    ),
 * ),
 */
class ForgotPasswordRequest extends FormRequest
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
        ];
    }
}