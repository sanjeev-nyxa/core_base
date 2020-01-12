<?php

namespace Labs\Modules\Support;


/**
 * Class Vue
 * @package Labs\Modules\Support
 */
class Vue
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
     * @param $name
     * @return bool|int
     */
    public function updateRoutesFile($name)
    {
        $filename = base_path("plugins/$this->module/Resources/assets/admin/pages/index.js"); // the file to change

        $search = '// ROUTE__CHILDREN'; // the content after which you want to insert new stuff
        $insert = "...$name,"; // your new stuff
        $replace = $insert . "\n             " . $search;
        file_put_contents($filename, str_replace($search, $replace, file_get_contents($filename)));

        $search = '// ROUTE__IMPORTS'; // the content after which you want to insert new stuff
        $insert = "import $name from './+$name'"; // your new stuff
        $replace = $insert . "\n" . $search;
        return file_put_contents($filename, str_replace($search, $replace, file_get_contents($filename)));
    }
}