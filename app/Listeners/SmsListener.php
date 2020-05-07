<?php

namespace App\Listeners;

use App\Log;
use Browser;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SmsListener
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


        $client = new \GuzzleHttp\Client(); //GuzzleHttp\Client
        $number = $event->mobile;
        $massege = $event->message;
        //dd($massege,$number);
        $result = $client->get('http://www.hotsms.ps/sendbulksms.php?user_name=yardimeli&user_pass=yardim&sender=Yardimeli&mobile=' . $number . '&type=2&text=' . $massege);
        $response = $result->getBody()->getContents();

        //"http://www.hotsms.ps/sendbulksms.php?user_name=test&user_pass=test&sender=test&mobile=972598683344&type=0&text=test";
    }
}
