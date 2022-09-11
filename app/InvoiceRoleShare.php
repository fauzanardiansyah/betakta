<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceRoleShare extends Model
{
    protected $table = 't_invoice_role_share';
    protected $guarded = [];

    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }
    
}
