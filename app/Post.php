<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';
    protected $guarded = [];
    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(\App\Category::class, 'id_category', 'id');
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class, 'id_post', 'id');
    }
}
