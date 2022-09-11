<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataDetailLegalitas extends Model
{
    protected $table = 't_detail_legalitas_kta';

    protected $guarded = [];

    public $timestamps = false;

    public function legalitasBu()
    {
        $this->hasOne(\App\DataLegalitasBadanUsaha::class);
    }
}
