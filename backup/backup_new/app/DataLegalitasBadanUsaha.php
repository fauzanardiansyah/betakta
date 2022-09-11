<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataLegalitasBadanUsaha extends Model
{
    
    protected $table = 't_legalitas_kta';
    protected $guarded = [];


    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }

    public function details()
    {
        return $this->hasMany(\App\DataDetailLegalitas::class, 'id_legalitas_bu', 'id');
    }
}
