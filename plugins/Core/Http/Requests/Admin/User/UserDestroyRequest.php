<?php

namespace Labs\Core\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserDestroyRequest
 * @package Labs\Core\Http\Requests\Admin\User
 * @SWG\Definition(
 *     definition="Core@AdminUserDestroyRequest",
 *     description="permission:delete_users"
 * ),
 */
class UserDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('delete_users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
