<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Episode extends Model implements Searchable
{
    use HasFactory;
    protected $fillable = ['tmdb_id', 'season_id', 'name', 'episode_number', 'is_public', 'visits',    'slug', 'overview'];

    public function getSearchResult(): SearchResult
    {
        $url = route('episodes.show', $this->slug);

        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function scopeQueryEpisodes($query, $slug) {
        return $this->where('slug', '!=', $slug);
    }
}
