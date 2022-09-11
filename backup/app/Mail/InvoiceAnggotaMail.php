<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceAnggotaMail extends Mailable
{
    protected $dataInvoiceAnggota;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataInvoiceAnggota)
    {
        $this->dataInvoiceAnggota = $dataInvoiceAnggota;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'ktaonline@inkindo.org';
        $subject = 'Invoice Anggota';
        $name = 'Inkindo';

        return $this->from($address, $name)
                           ->subject($subject)
                           ->view('emails-template/backend.invoice-anggota', ['dataInvoiceAnggota' => $this->dataInvoiceAnggota]);
    }
}
