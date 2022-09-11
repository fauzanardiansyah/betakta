<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceRoleShareMail extends Mailable
{
    protected $dataInvoiceRoleShare;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataInvoiceRoleShare)
    {
        $this->dataInvoiceRoleShare = $dataInvoiceRoleShare;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $address = 'ktaonline@inkindo.org';
        $subject = 'Invoice Role Sharing';
        $name    = 'DPN Inkindo';


        return $this->from($address, $name)
                           ->subject($subject)
                           ->view('emails-template/backend.invoice-role-share', ['dataInvoiceRoleShare' => $this->dataInvoiceRoleShare]);
    }
}

