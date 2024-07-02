<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MovieController extends Controller
{
    public function index()
    {
        return Inertia::render('FrontEnd/Movies/Index', [
            'movies' => Movie::orderBy('created_at', 'DESC')->with('genres')->paginate(12)
        ]);
    }

    public function show(Movie $movie)
    {

        $latest = Movie::orderBy('created_at', 'DESC')->take(9)->get();
        return Inertia::render('FrontEnd/Movies/Show', [
            'movie' => $movie,
            'latest' => $latest,
            'genres' => $movie->genres,
            'casts' => $movie->casts,
            'tags' => $movie->tags,
            'trailers' => $movie->trailers,
        ]);
    }
}
