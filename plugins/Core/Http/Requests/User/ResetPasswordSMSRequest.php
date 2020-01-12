<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordSMSRequest
 * @package Labs\Core\Http\Requests\Participant
 */
class ResetPasswordSMSRequest extends FormRequest
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
            'token' => ['required', 'exists:users,id'],
            'mobile_number' => ['required', 'exists:users,mobile_number'],
            'mobile_number_code' => ['required', 'exists:users,mobile_number_code'],
            'password' => ['required', 'confirmed', 'max:255', 'min:6']
        ];
    }
}