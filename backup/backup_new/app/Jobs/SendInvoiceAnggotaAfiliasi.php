<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\InvoiceAnggotaAfiliasi as InvoiceAnggotaAfiliasi;
use Mail;

class SendInvoiceAnggotaAfiliasi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataInvoiceAnggotaAfiliasi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataInvoiceAnggotaAfiliasi)
    {
        $this->dataInvoiceAnggotaAfiliasi = $dataInvoiceAnggotaAfiliasi;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataInvoiceAnggotaAfiliasi = $this->dataInvoiceAnggotaAfiliasi;
        Mail::to($dataInvoiceAnggotaAfiliasi['kta']->email_bu)->send(new InvoiceAnggotaAfiliasi($dataInvoiceAnggotaAfiliasi));
    }
}
