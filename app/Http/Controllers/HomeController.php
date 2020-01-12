<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    private function render()
    {
        $renderer_source = File::get(base_path('node_modules/vue-server-renderer/basic.js'));
        $app_source = File::get(public_path('admin/js/app.js'));
        $v8 = new \V8Js();
        ob_start();
        $js =
            <<<EOT
var process = { env: { VUE_ENV: "server", NODE_ENV: "production" } }; 
this.global = { process: process };
EOT;
        $v8->executeString($js);
        $v8->executeString($renderer_source);
        $v8->executeString($app_source);
        return ob_get_clean();
    }

    public function get()
    {
        $ssr = $this->render();
        return view('app', ['ssr' => $ssr]);
    }
}
