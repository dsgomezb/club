<?php

namespace App;

use App\Classes\Tabulate;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use Tabulate;

    public $timestamps = false;

    protected $table = 'newsletter';

    protected $fillable = ['email'];

    public function scopeSearchQuery($query, $searchTerm)
    {
        return $query->where('email', 'like', "%$searchTerm%");
    }
}
