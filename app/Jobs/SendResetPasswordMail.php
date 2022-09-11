<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\ResetPasswordUser as ResetPasswordUser;
use Mail;

class SendResetPasswordMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataUser)
    {
        $this->dataUser = $dataUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataUser = $this->dataUser;
        Mail::to($dataUser->email_bu)->send(new ResetPasswordUser($dataUser));
    }
}
