<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleShareConfirmation extends Model
{
    protected $table = 't_role_share_confirmation';
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(\App\InvoiceRoleShare::class, 'id_invoice_role_share', 'id');
    }
}
