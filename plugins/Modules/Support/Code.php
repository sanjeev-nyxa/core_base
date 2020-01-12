<?php

namespace Labs\Modules\Support;

/**
 * Class Code
 * @package Labs\Modules\Support
 */
class Code
{
    /**
     * @var
     */
    private $module;

    /**
     * Vue constructor.
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * @param $permission
     * @return bool|int
     */
    public function addNewPermissionToListener($permission)
    {
        $filename = base_path("plugins/$this->module/Listeners/GetAppPermissionsListener.php"); // the file to change

        $search = '// PERMISSIONS_HANDLER'; // the content after which you want to insert new stuff
        $insert = "->push('$permission')"; // your new stuff
        $replace = $insert . "\n             " . $search;

        return file_put_contents($filename, str_replace($search, $replace, file_get_contents($filename)));
    }
}