<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DewanPengurus extends Model
{
    protected $table = 't_dp';
    protected $guarded = [];

    public function provinsi()
    {
        return $this->belongsTo(\App\Provinsi::class, 'id_provinsi', 'id');
    }
}
