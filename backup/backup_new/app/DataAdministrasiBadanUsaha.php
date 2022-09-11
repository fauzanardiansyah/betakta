<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataAdministrasiBadanUsaha extends Model
{
    protected $table = 't_administrasi_kta';
    protected $guarded = [];


    public function detailKta()
    {
        return $this->hasOne(\App\DetailKta::class);
    }
}
