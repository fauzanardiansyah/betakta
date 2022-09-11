<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceAnggotaAfiliasi extends Mailable
{
    protected $dataInvoiceAnggotaAfiliasi;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataInvoiceAnggotaAfiliasi)
    {
        $this->dataInvoiceAnggotaAfiliasi = $dataInvoiceAnggotaAfiliasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'ktaonline@inkindo.org';
        $subject = 'Invoice Anggota Afiliasi';
        $name = 'Inkindo';

        return $this->from($address, $name)
                           ->subject($subject)
                           ->view('emails-template/backend.invoice-anggota-afiliasi', ['dataInvoiceAnggotaAfiliasi' => $this->dataInvoiceAnggotaAfiliasi]);
    }
}
