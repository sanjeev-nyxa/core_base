<?php

namespace Labs\Core\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserUpdateRequest
 * @package Labs\Core\Http\Requests\Admin\User
 * @SWG\Definition(
 *     definition="Core@AdminUserUpdateRequest",
 *     description="permission:update_users",
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
class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gender' => ['nullable', Rule::in(['Men', 'Women'])],
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'roles' => ['array']
        ];
    }
}
