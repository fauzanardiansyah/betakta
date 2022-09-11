<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleShareAccumulation extends Model
{
    protected $table = 't_role_share_accumulation';
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(\App\RoleShareConfirmation::class, 'id_role_share_accumulation', 'id');
    }
}
