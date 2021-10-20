<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageInfo extends Model
{

    protected $fillable = ['name', 'value', 'image_id'];
    protected $table = 'images_info';
    public $timestamps = false;

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

}
