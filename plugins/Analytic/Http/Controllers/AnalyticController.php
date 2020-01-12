<?php

namespace Labs\Analytic\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Labs\Analytic\Http\Resource\Admin\DataChartResource;
use Labs\Core\Http\Controllers\Controller;


/**
 * Class AnalyticController
 * @package Zix\PluginName\Http\Controllers
 */
class AnalyticController extends Controller
{
    public function index(Request $request)
    {
        $class = $request->get('model');
        return new DataChartResource((new $class)->all());
    }
}
