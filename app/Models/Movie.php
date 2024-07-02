<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Movie extends Model implements Searchable
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'title', 'release_date', 'runtime', 'lang', 'video_format', 'is_public', 'visits', 'slug', 'rating', 'poster_path', 'backdrop_path', 'overview'];

    public function getSearchResult(): SearchResult
    {
        $url = route('movies.show', $this->slug);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_movies');
    }

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(Cast::class, 'cast_movies');
    }

    public function trailers(): MorphMany
    {
        return $this->morphMany(TrailerUrl::class, 'trailerable');
    }
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
