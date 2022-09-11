<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class M_warning extends Model
{
    //
    protected $table = 't_warning';
    protected $guarded = [];
    protected $primaryKey = 'id_warning';
    public $incrementing = false;
}
