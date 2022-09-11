<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataUser)
    {
        $this->dataUser = $dataUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'ktaonline@inkindo.org';
        $subject = 'Account activation';
        $name = 'Inkindo';

        return $this->from($address, $name)
                           ->subject($subject)
                           ->view('emails-template/frontend.activation-user', ['dataUser' => $this->dataUser]);
    }
}
