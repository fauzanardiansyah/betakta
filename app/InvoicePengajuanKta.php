<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePengajuanKta extends Model
{
    protected $table = 't_invoice_kta';
    protected $guarded = [];

    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }
}
