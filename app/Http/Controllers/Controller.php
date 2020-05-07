<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected $user;
    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {


            $this->user = Auth::user();
//            Config::set('SESSION_LIFETIME',1);
////            dd(Config::get('session.lifetime',1));
//
//            Artisan::call('config:clear');
////                Artisan::call('cache:clear');
//                Artisan::call('config:cache');

            View::share('user', $this->user);
            return $next($request);

        });
    }
}