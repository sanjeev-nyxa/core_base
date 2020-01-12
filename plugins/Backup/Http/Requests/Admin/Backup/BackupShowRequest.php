<?php

namespace Labs\Backup\Http\Requests\Admin\Backup;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BackupShowRequest
 * @package Labs\Backup\Http\Requests\Admin\Backup
 * @SWG\Definition(
 *     definition="Backup@AdminBackupShowRequest",
 *     description="null"
 * ),
 */
class BackupShowRequest extends FormRequest
{
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

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
