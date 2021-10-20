<?php

namespace App;

use App\Classes\Tabulate;
use App\Classes\ToForm;
use App\Events\ModelModified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravelista\Comments\Commenter;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable implements MustVerifyEmail
{
    use Tabulate, ToForm, Commenter, Notifiable;

    protected $fillable = [
        'username',
        'about',
        'email',
        'reason',
        'reference',
        'password',
        'image',
        'is_banned',
        'is_approved',
        'email_vefiied_at',
        'stars'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function califications()
    {
        return $this->hasManyThrough(Calification::class, Post::class);
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    //getters y setters
    public function getFullNameAttribute()
    {
        return $this->username;
    }
    
    public function getThumbAttribute()
    {
        return $this->image ?? 'imagen-no-disponible.jpg';
    }

    public function getProfilePathAttribute()
    {
        return '/perfil/'.$this->username;
    }
    //-----------------

    public function updateRanking()
    {
        $this->update(['stars'=>round($this->califications()->avg("stars"),0 )]);
    }

    //Tabulate
    public function scopeSearchQuery($query, $searchTerm)
    {
        return $query->where('username', 'like', "$searchTerm%")
            ->orWhere('email', 'like', "$searchTerm%")
        ;
    }

    private function getOrderBy()
    {
        return ['created_at', 'desc'];
    }
}
