<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetailKta extends Model
{

    protected $table     = 't_detail_kta';

    protected $guarded   = [];
    
    public $incrementing = false;

   
    public function administrasiBu()
    {
        return $this->hasMany(\App\DataAdministrasiBadanUsaha::class, 'id_detail_kta');
    }

    public function historyApps()
    {
        return $this->hasMany(\App\HistoryApprovalPengajuan::class, 'id_detail_kta');
    }

    public function pemberhentianAgt()
    {
        return $this->hasMany(\App\PemberhentianAnggota::class, 'id_detail_kta');
    }

    public function kta()
    {
        return $this->belongsTo(\App\Kta::class, 'id_kta');
    }
}
