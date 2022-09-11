<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPenanggungJawabBadanUsaha extends Model
{
    protected $table = 't_pj_kta';
    protected $guarded = [];


    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }
}
