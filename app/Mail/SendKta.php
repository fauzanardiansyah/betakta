<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendKta extends Mailable
{
    private $dataKta;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $dataKta)
    {
        //
        $this->dataKta = $dataKta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails-template.backend.send-kta')
        ->subject('KTA INKINDO - Pengiriman KTA Melalui Email')
        // ->with(
        //     [
        //         'name' => $this->regis['name'],
        //         'password'=>$this->regis['password'],
        //         'email'=>$this->regis['email'],
        //         'id'=>$this->regis['id'],
        //     ]
        // );
        ;
    }
}
