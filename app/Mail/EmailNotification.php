<?php

namespace App\Mail;

use http\Env;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        return $this->subject('Test email')
            ->view($this->view)
            ->from($configController->getConfigByKey('email_from') ?? env("MAIL_FROM_ADDRESS"))
            ->to($configController->getConfigByKey('email_to') ?? env("MAIL_TO_ADDRESS"));
    }
}
