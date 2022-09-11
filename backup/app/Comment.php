<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';
    protected $guarded = [];
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(\App\Post::class);
    }
}
