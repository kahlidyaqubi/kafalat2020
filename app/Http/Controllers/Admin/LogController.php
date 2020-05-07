<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Log;
use App\LogCategory;
use App\User;
use DataTables;

/**
 * Class LogController
 * @package App\Http\Controllers\Admin
 */
class LogController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.log.logList');
    }

    /**
     * @return mixed
     */
    public function getLogs()
    {
        $logs = Log::all();
        return DataTables::of($logs)
            ->editColumn('message', function ($value) {
                $event = !is_null($value->message) ? $value->message : null;
                $name = !is_null($value->name) ? $value->name : null;

                if ($value->path_status == 0) {
                    return "<span > $event </span>&nbsp;
                    <strong class='text-red'> $name  </strong>";
                } else {
                    return "<span > $event </span>&nbsp;
                    <strong class='text-red'><a href='$value->path'> $name  </a></strong>";
                }
            })->addColumn('category', function ($value) {
                return isset($value->log_category) ? $value->log_category->name : null;
            })
            ->addColumn('ip_address', function ($value) {
                return isset($value->ip_address) ? $value->ip_address : null;
            })
            ->addColumn('date', function ($value) {
                return isset($value->created_at) ? date_format($value->created_at, 'Y-m-d') : null;
            })->addColumn('time', function ($value) {
                return isset($value->created_at) ? date_format($value->created_at, 'H:i') : null;
            })
            ->addColumn('user', function ($value) {
                return isset($value->user_id) ? User::find($value->user_id)->user_name : null;
            })
            ->addColumn('agent', function ($value) {
                $agentName = isset($value->agent) ? $value->agent : null;
                return $agentName;
            })
            ->addColumn('device', function ($value) {
                $theDevice = isset($value->device) ? $value->device : null;
                $theDevicePlatform = isset($value->device_platform) ? $value->device_platform : null;
                return $theDevice . ' - ' . $theDevicePlatform;
            })
            ->rawColumns(['message'])->make(true);
    }

}
