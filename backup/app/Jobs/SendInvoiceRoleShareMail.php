<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\InvoiceRoleShareMail as InvoiceRoleShareMail;
use Mail;

class SendInvoiceRoleShareMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataInvoiceRoleShare;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataInvoiceRoleShare)
    {
        $this->dataInvoiceRoleShare = $dataInvoiceRoleShare;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataInvoiceRoleShare = $this->dataInvoiceRoleShare;
        Mail::to($dataInvoiceRoleShare['dpp']->email_dewan_pengurus)->send(new InvoiceRoleShareMail($dataInvoiceRoleShare));
    }
}
