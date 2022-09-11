<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentConfirmation extends Model
{
    protected $table = 't_payment_confirmation';
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(\App\InvoicePengajuanKta::class, 'id_invoice_kta', 'id');
    }
}
