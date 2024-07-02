<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Movie;
use App\Models\Tag;
use App\Models\TrailerUrl;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrailerUrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Movie $movie)
    {
        return Inertia::render('Admin/Movies/Trailers', [
            'movie' => $movie,
            'casts' => Cast::all('id', 'name'),
            'tags' => Tag::all('id', 'tag_name'),
            'trailers' => $movie->trailers,
            'movieCasts' => $movie->casts,
            'movieTags' => $movie->tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Movie $movie)
    {
        if ($request->name || $request->embed_html) {
            $validated = $this->validate($request, [
                'name' => 'required',
                'embed_html' => 'required'
            ]);
            $movie->trailers()->create($validated);
        }

        if (count($request->casts) > 0) {
            $casts = collect($request->casts)->pluck('id');
            $movie->casts()->sync($casts);
        }

        if (count($request->tags) > 0) {
            $tags = collect($request->tags)->pluck('id');
            $movie->tags()->sync($tags);
        }

        return to_route('admin.movies.index')->with('success', 'Success Add Trailers');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrailerUrl $trailerUrl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrailerUrl $trailerUrl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrailerUrl $trailerUrl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrailerUrl $trailerUrl)
    {
        if ($trailerUrl) {
            $trailerUrl->delete();
            return back()->with('success', 'Success Deleted Trailer');
        }
    }
}
