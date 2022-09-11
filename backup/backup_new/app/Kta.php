<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kta extends Model
{
    protected $table = 't_kta';
    protected $guarded = [];
    public $incrementing = false;

    public function detailKta()
    {
        return $this->hasMany(\App\DetailKta::class, 'id_kta', 'id');
    }

    public function registrasiUsers()
    {
        return $this->belongsTo(\App\RegistrationUsers::class, 'id_registrasi_users', 'id');
    }
}
