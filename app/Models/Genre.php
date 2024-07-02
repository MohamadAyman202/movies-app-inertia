<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'title', 'slug'];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'genre_movies');
    }
}
