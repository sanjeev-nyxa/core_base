<?php

namespace Labs\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Base64Validator
 * @package Labs\Core\Rules
 */
class Base64Validator implements Rule
{
    public $description = 'The Value must be a valid Base64(png, jpg, jpeg,, svg) string.';

    /**
     * @return string
     */
    public function __toString()
    {
        return "base64";
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $explode = explode(',', $value);
        $allow = ['png', 'jpg', 'svg', 'jpeg'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );
        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }
        // check base64 format
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Base64(png, jpg, jpeg,, svg) string.';
    }
}
