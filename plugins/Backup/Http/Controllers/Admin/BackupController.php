<?php

namespace Labs\Backup\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Labs\Backup\Http\Requests\Admin\Backup as BackupRequests;
use Labs\Backup\Http\Resource\Admin\BackupResource;
use Labs\Core\Http\Controllers\Controller;
use Spatie\Backup\Helpers\Format;
use ZipArchive;

/**
 * Class BackupController
 * @package Labs\Backup\\Http\Controllers/Admin
 */
class BackupController extends Controller
{

    /**
     * @SWG\Get(
     *     path="/admin/backups",
     *     tags={"Admin Backup Backups"},
     *     summary="Get Backup List",
     *     @SWG\Response(
     *          response=200,
     *          description="ORACLE Fluent Query Response.",
     *      ),
     * ),
     * @param BackupRequests\BackupShowRequest $request
     * @return BackupResource
     */
    public function index(BackupRequests\BackupShowRequest $request)
    {
        if (!count(config('backup.backup.destination.disks'))) {
            dd(trans('backpack::backup.no_disks_configured'));
        }
        $data = [];

        $disk = $this->getDisk();
        $files = $disk->files($this->getBackupsName());
        // make an array of backup files, with their filesize and creation date
        foreach ($files as $k => $f) {
            // only take the zip files into account
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $data[] = [
                    'file_path' => $f,
                    'name' => str_replace($this->getBackupsName() . '/', '', $f),
                    'size' => Format::humanReadableSize($disk->size($f)),
                    'newest' => Format::ageInDays(Carbon::createFromTimestamp($disk->lastModified($f))),
                    'url' => Storage::url($f),
                ];
            }
        }

        return datatables()->collection(collect($data))->toJson();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        Artisan::call('backup:run');
        return response()->json([true]);
    }

    /**
     * @param Request $request
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function download(Request $request)
    {
        return $this->getDisk()->get($request->get('path'));
    }

    /**
     * @param Request $request
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('items')) {
            foreach ($request->file('items') as $file) {
                $this->getDisk()->putFileAs($this->getBackupsName(), $file, $file->getClientOriginalName());
            }
        }
        return dd($request->file("items"));
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function restore(Request $request)
    {

        if ($request->has('path')) {
            $zip = new ZipArchive();
            $zip->open(storage_path('app/backups/' . $request->get('path')));
            $zip->extractTo(storage_path('app/backups/') . 'unzipped');

            $disk = $this->getDisk();
            foreach ($disk->allFiles('unzipped/db-dumps') as $file) {
                \DB::unprepared($disk->get($file));
            }


            // TODO:: fix the logic to copy unsipped folders
//            foreach ($disk->allDirectories('unzipped') as $directory) {
//
//                if(str_contains($directory, 'config')) {
//                    $this->recurse_copy(storage_path("app/backups/".$directory), base_path('config'));
//                }
//                if(str_contains($directory, 'public')) {
//                    dd(storage_path("app/backups/".$directory));
//                    $this->recurse_copy(storage_path("app/backups/".$directory), base_path('public'));
//                }
//            }

            // 1. copy and overwrite app folders
            // 2. clean the unzipped folders
            // 3. restore the db
            // 4. clean the db
            $disk->deleteDirectory('unzipped');
            Cache::flush();
        }
    }

    /**
     * @param Request $request
     * @param $backup
     * @return mixed
     */
    public function destroy(Request $request, $backup)
    {
        $this->getDisk()->delete($this->getBackupsName() . '/' . $backup);
        return $backup;
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    private function getDisk()
    {
        if (config('backup.backup.destination.disks') && config('backup.backup.destination.disks')[0]) {
            return Storage::disk(config('backup.backup.destination.disks')[0]);
        }
        dd('No Backup Disk Found');
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getBackupsName()
    {
        return config('backup.backup.name');
    }

    /**
     * @param $src
     * @param $dst
     */
    private function recurse_copy2($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    private function recurse_copy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->recurse_copy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();
        return true;
    }

}
