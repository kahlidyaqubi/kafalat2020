<?php

namespace App\Listeners;

use App\Log;
use Browser;
use Illuminate\Support\Facades\Auth;

class SaveEventInLogTable
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        $device = '';
        $log = [];

        if (Browser::isMobile()) {
            $device = 'Mobile';
        } elseif (Browser::isTablet()) {
            $device = 'Tablet';
        } elseif (Browser::isDesktop()) {
            $device = 'Desktop';
        } elseif (Browser::isBot()) {
            $device = 'Bot';
        } else {
            $device = '';
        }

        $log['message'] = $event->message;
        $log['path'] = $event->path;
        $log['ip_address'] = \Request::ip();
        $log['agent'] = Browser::browserName();
        $log['device'] = $device;
        $log['device_platform'] = Browser::platformName();
        $log['name'] = $event->name;
        $log['log_category_id'] = $event->log_category_id;
        $log['path_status'] = $event->path_status;
        $log['user_id'] = Auth::user()->id;

        Log::create($log);
    }
}
