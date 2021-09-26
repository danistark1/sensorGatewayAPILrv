<?php

namespace App\Listeners;

use App\Events\SensorDataSaved;
use App\Mail\EmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSensorEmailNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SensorDataSaved  $event
     * @return void
     */
    public function handle(SensorDataSaved $event) {
        // Check if a notification / report is eligible to be sent
        // Render email template based on that
        Mail::send(new EmailNotification([$event], 'email-template'));

    }
}
