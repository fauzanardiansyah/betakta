<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    protected $guarded = [];

    public function dewan()
    {
        return $this->hasOne(\App\DewanPengurus::class);
    }
}
