<?php

namespace Labs\Core\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PermissionStoreRequest
 * @package Labs\Core\Http\Requests\Admin\Permission
 * @SWG\Definition(
 *     definition="Core@AdminPermissionStoreRequest",
 *     description="permission:create_permission"
 * ),
 */
class PermissionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create_permission');
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
