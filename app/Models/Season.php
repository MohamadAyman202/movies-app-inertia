<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Season extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = ['tmdb_id', 'tv_show_id', 'name', 'season_number', 'slug', 'poster_path'];


    public function setSlugAttribute($value)
    {
        $name = $this->attributes['name'];
        $this->attributes['slug'] = str()->slug($name);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('season.show', [$this->tvShow->slug, $this->slug]);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function TvShow()
    {
        return $this->belongsTo(TvShow::class);
    }
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }
}
