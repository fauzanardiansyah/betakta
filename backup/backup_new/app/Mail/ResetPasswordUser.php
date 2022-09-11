<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordUser extends Mailable
{
    use Queueable, SerializesModels;

    private $dataUser;

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
        return $this->from('dpn@inkindo.com', 'DPN INKINDO')
        ->subject('KTA Online Account Reset')
        ->view('emails-template/frontend.reset-password-user', ['dataUser' => $this->dataUser]);
    }
}
