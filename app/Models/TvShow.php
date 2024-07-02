<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class TvShow extends Model implements Searchable
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'name', 'slug', 'created_year', 'poster_path', 'visits'];

    public function getSearchResult(): SearchResult
    {
        $url = route('tvShow.show', $this->slug);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function setSlugAttribute($value)
    {
        $name = $this->attributes['name'];
        $this->attributes['slug'] = str()->slug($name);
    }
    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
