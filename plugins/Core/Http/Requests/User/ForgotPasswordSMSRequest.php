<?php

namespace Labs\Core\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ForgotPasswordSMSRequest
 * @package Labs\Core\Http\Requests\Participant
 * @SWG\Definition(
 *     definition="Core@ForgotPasswordSMSRequest",
 *     required={"mobile_number"},
 *     @SWG\Property(
 *          property="mobile_number",
 *          type="mobile_number",
 *          description="Mobile Number",
 *          example="+123456798"
 *    ),
 * ),
 */
class ForgotPasswordSMSRequest extends FormRequest
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
            'mobile_number' => ['required', 'exists:users,mobile_number'],
        ];
    }
}