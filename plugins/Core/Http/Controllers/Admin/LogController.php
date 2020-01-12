<?php

namespace Labs\Core\Http\Controllers\Admin;

use Labs\Core\Http\Controllers\Controller;
use Labs\Core\Http\Requests\Admin\Log as LogRequests;
use Labs\Core\Support\LaravelLogViewer\LaravelLogViewer;

/**
 * Class LogController
 * @package Labs\Core\\Http\Controllers/Admin
 */
class LogController extends Controller
{

    /**
     * @var LaravelLogViewer
     */
    private $log_viewer;

    /**
     * LogViewerController constructor.
     */
    public function __construct()
    {
        $this->log_viewer = new LaravelLogViewer();
    }

    /**
     * @param LogRequests\LogShowRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LogRequests\LogShowRequest $request)
    {
        return datatables()->collection($this->log_viewer->all())->toJson();
    }


}
