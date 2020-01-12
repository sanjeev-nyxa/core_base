<?php

namespace Labs\Core\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Labs\Core\Rules\Base64Validator;

/**
 * Class UpdateAvatarRequest
 * @package Labs\Core\Http\Requests\User
 * @SWG\Definition(
 *     definition="Core@UpdateAvatarRequest",
 *     required={"avatar"},
 *     @SWG\Property(
 *          property="avatar",
 *          type="file",
 *          description="The Value must be a valid Base64(png, jpg, jpeg, svg) string.",
 *          example="data:image/png;base64,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"
 *    ),
 * ),
 */
class UpdateAvatarRequest extends FormRequest
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
            'avatar' => ['required', new Base64Validator]
        ];
    }
}
