<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calification extends Model
{
    protected $fillable = ['stars', 'author_id', 'post_id'];

    public function author()
    {
    	return $this->belongsTo(User::class,'author_id');
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

}
