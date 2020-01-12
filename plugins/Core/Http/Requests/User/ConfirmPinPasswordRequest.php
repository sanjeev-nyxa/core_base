<?php

namespace Labs\Core\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ConfirmPinPasswordRequest
 * @package Labs\Core\Http\Requests\User
 * @SWG\Definition(
 *     definition="Core@ConfirmPinPasswordRequest",
 *     required={"mobile_number"},
 *     @SWG\Property(
 *          property="mobile_number",
 *          type="string",
 *          description="Mobile Number",
 *          example="+123456789"
 *    ),
 *    @SWG\Property(
 *          property="mobile_number_code",
 *          type="string",
 *          description="Mobile Number Code",
 *          example="9999"
 *    ),
 * ),
 */
class ConfirmPinPasswordRequest extends FormRequest
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
            'mobile_number_code' => ['required', 'exists:users,mobile_number_code'],
        ];
    }
}
