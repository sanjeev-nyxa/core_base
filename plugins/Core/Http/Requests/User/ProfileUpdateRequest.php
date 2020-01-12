<?php

namespace Labs\Core\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ProfileUpdateRequest
 * @package Labs\Core\Http\Requests\User
 * @SWG\Definition(
 *     definition="Core@ProfileUpdateRequest",
 *     required={"email", "first_name", "last_name", "phone_number", "lang", "gender"},
 *     @SWG\Property(
 *          property="email",
 *          type="email",
 *          description="Email",
 *          example="example@example.com"
 *    ),
 *    @SWG\Property(
 *          property="first_name",
 *          type="string",
 *          description="First Name",
 *          example="Badi"
 *    ),
 *    @SWG\Property(
 *          property="last_name",
 *          type="string",
 *          description="Last Name",
 *          example="Ifaoui"
 *    ),
 *    @SWG\Property(
 *          property="phone_number",
 *          type="string",
 *          description="Phone Number",
 *          example="+123456798"
 *    ),
 *    @SWG\Property(
 *          property="lang",
 *          type="string",
 *          description="Lang",
 *          example="en"
 *    ),
 *    @SWG\Property(
 *          property="gender",
 *          type="string",
 *          description="Gender",
 *          example="Men"
 *    ),
 * ),
 */
class ProfileUpdateRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->id)],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone_number' => ['required', 'max:255', Rule::unique('users', 'phone_number')->ignore($this->id)],
            'lang' => ['nullable', Rule::in(['en', 'fr'])],
            'gender' => ['nullable', Rule::in(['Men', 'Women'])],
        ];
    }
}
