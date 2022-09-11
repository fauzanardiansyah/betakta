<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDokumenPendukungBadanUsaha extends Model
{
    protected $table = 't_dokumen_kta';
    protected $guarded = [];

    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }
}
