<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Action;
use App\Jobs\MyJob;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
      
     /*  \Illuminate\Support\Facades\Artisan::call('queue:work --tries=3 --stop-when-empty');*/
        // $schedule->command('inspire')
        //          ->hourly();
        //dd(Carbon::now());
       /* $schedule->command('backup:run  --disable-notifications')->daily()->at('12:50');*/
      /* $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();;*/
       $myreq = session()->get('myreq') ?? "";
            $id = session()->get('id') ?? "";
       $schedule->job(new MyJob($myreq,$id))->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
