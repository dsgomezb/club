<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    protected $fillable = ['src','url','imageable_id','imageable_type','is_video','pending','order'];

    public function __get($name)
    {
        $prop = null;
        if (parent::__get($name)) {
            $prop = parent::__get($name);
        } elseif ($this->info->contains('name', $name)) {
            $prop = $this->info()->where('name', $name)->where('image_id', $this->id)->first()->value;
        }
        return $prop;
    }

    public function toArray()
    {
        return array_merge($this->info->pluck('value', 'name')->toArray(), parent::toArray());
    }

    public function info()
    {
        return $this->hasMany('App\ImageInfo');
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    public static function nextId ()
    {
        if (!$imagen = self::select('id')->orderBy('id', 'desc')->first()) {
            $imagen = new self;
            $imagen->id = 0;
        }
        return $imagen->id + 1;
    }

    public function iframe()
    {
        $url = $this->url;
        $response;
        if (!filter_var($url, FILTER_VALIDATE_URL)) $response = false;
        $domain = parse_url($url, PHP_URL_HOST);
        if ($domain == 'www.youtube.com' || $domain == 'youtube.com' || $domain == 'youtu.be') {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $response = '<div class="background-video-player-box video-box ratio-16-9"><iframe src="https://www.youtube.com/embed/'.$match[1].'?rel=0&autoplay=0&mute=1&loop=1" width="700px" height="500px" frameborder="0" allowfullscreen></iframe></div>';
        } elseif ($domain == 'vimeo.com') { //vimeo
           if (preg_match("/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $url, $id)) {
                $response = '<div class="background-video-player-box video-box ratio-16-9"><iframe src="//player.vimeo.com/video/'.$id[3].'?autoplay=0&loop=1" width="700px" height="500px" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
            }
        } else {
            $response = false;
        }
        return $response;
    }

}
