<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\configController;

class EmailNotification extends Mailable {
    use Queueable, SerializesModels;

    public $details;

    /** view blade template */
    public $view;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $view) {
        $this->details = $details;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(configController $configController) {
        $from  = empty($from = $configController->getConfigByKey('email_from')) ? env("MAIL_FROM_ADDRESS") : $from;

         $to =  env("MAIL_TO_ADDRESS", "danistark.ca@gmail.com");


        return $this->subject('Test email')
            ->view($this->view)
            ->from($from)
            ->to($to);
    }
}
