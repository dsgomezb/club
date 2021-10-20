<?php

namespace App;

use App\Classes\Tabulate;
use App\Classes\ToForm;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Tabulate, ToForm, Sluggable;

    protected $fillable = ['value'];

    const BUSINESSES = 1;

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'value',
                'includeTrashed' => true,
                'onUpdate' => true,
            ]
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //tabulate
    public function scopeTabulateQuery($query)
    {
    	return $query->withCount('posts');
    }
    //-------
}
