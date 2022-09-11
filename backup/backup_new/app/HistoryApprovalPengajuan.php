<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryApprovalPengajuan extends Model
{
    protected $table = 't_app_kta';

    protected $guarded = [];

    public function detailKta()
    {
        $this->hasOne(\App\DetailKta::class);
    }
}
