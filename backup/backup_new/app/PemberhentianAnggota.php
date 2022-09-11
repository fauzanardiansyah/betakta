<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemberhentianAnggota extends Model
{
    protected $table = 't_pemberhentian_agt';
    protected $guarded = [];

    public function detailKta()
    {
        return $this->hasMany(\App\DetailKta::class, 'id_kta', 'id');
    }
}
