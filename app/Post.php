<?php

namespace App;

use App\Classes\Searchable;
use App\Classes\Tabulate;
use App\Classes\ToForm;
use App\Classes\Unite;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

class Post extends Model
{
    use Tabulate, ToForm, Commentable, Sluggable, Searchable, Unite;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'published_at',
        'is_visible',
        'category_id',
        'user_id',
        'location',
        'zone',
        'minimum_investment',
        'company',
        'start',
        'views',
    ];

    protected $dates = ['published_at'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'includeTrashed' => true,
                'onUpdate' => true,
            ]
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('order');
    }

    

    public function authIsAuthor()
    {
        return $this->user_id == \Auth('user')->id();
    }

    public function canQualify()
    {
        return !$this->authIsAuthor();
    }

    public function getAuthQualification()
    {
        $calification = \App\Calification::where('author_id',\Auth("user")->id())
            ->where("post_id",$this->id)
            ->first()
        ;
        return $calification->stars ?? 0;
    }

    //Getters y Setter
    public function getThumbAttribute()
    {
        $image = 'imagen-no-disponible.jpg';
        if ($this->images->count()) $image = $this->images->first()->src;
        return $image;
    }

    public function getImage1Attribute()
    {
        $image = null;
        if ($image = $this->images->get(0)) $image = $image->src;
        return $image;
    }

    public function getImage2Attribute()
    {
        $image = null;
        if ($image = $this->images->get(1)) $image = $image->src;
        return $image;
    }

    public function getImage3Attribute()
    {
        $image = null;
        if ($image = $this->images->get(2)) $image = $image->src;
        return $image;
    }

    public function getImage4Attribute()
    {
        $image = null;
        if ($image = $this->images->get(3)) $image = $image->src;
        return $image;
    }

    public function getImage5Attribute()
    {
        $image = null;
        if ($image = $this->images->get(4)) $image = $image->src;
        return $image;
    }

    public function getImage6Attribute()
    {
        $image = null;
        if ($image = $this->images->get(5)) $image = $image->src;
        return $image;
    }

    //Scopes
    public function scopePopulars($query, $limit=5)
    {
        $query->where('is_visible', 1)->orderBy('views', 'desc')->limit($limit);
    }

    //Tabulate
    public function scopeTabulateQuery($query)
    {
        return $query->with('images', 'author', 'category');
    }

    private function getOrderBy()
    {
        return ['published_at', 'desc'];
    }
}
