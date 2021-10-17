<?php

namespace App\Listeners;

use App\Events\SensorReports;
use App\Mail\EmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendSensorEmailNotification implements ShouldQueue
{

    public static $counter  = 0;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
        self::$counter = self::$counter  +1 ;
    }

    /**
     * Handle the event.
     *
     * @param  SensorReports  $event
     * @return void
     */
    public function handle($event) {



        // Get reportType in sensorData
        // Get number of reports to be sent per day from config for that report
        // Get last sent report with same type (from today) and check the counter
        // If counter is less than the max-per-day, sent report, update the counter
        // Else, return and don't sent.
      //  var_dump($result);
        // Check if a notification / report is eligible to be sent
        // Render email template based on that
       Mail::send(new EmailNotification([$event], 'email-template'));

    }
}
