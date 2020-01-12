<?php

namespace Labs\Core\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserShowRequest
 * @package Labs\Core\Http\Requests\Admin\User
 * @SWG\Definition(
 *     definition="Core@AdminUserShowRequest",
 *     description="permission:view_users"
 * ),
 */
class UserShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('view_users');
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
