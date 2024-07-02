<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prePage = FacadesRequest::input('prePage') ?: 5;

        $movies = Movie::when(FacadesRequest::input('search'), function ($query, $search) {
            $query->where('title', 'like', "%{$search}%");
        })->paginate($prePage)->withQueryString();

        $filters = FacadesRequest::only(['filters', 'search']);


        return Inertia::render('Admin/Movies/Index', [
            'movies' => $movies,
            'filters' => $filters,
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
    public function store(Request $request)
    {
        $movies = Movie::where('tmdb_id', $request->tmdb_movie)->exists();

        if ($movies) return back()->with('error', 'Movie already exists');

        $TMDB_SECRET_KEY = env('TMDB_SECRET_KEY');
        $TMDB_ENDPOINT = env('TMDB_ENDPOINT');

        $api_movie = Http::get("$TMDB_ENDPOINT/movie/$request->tmdb_movie?api_key=$TMDB_SECRET_KEY");

        if ($api_movie->successful()) {
            $tmdb_movie = $api_movie->json();

            $created_movies = Movie::query()->create([
                'tmdb_id' => $tmdb_movie['id'],
                'title' => $tmdb_movie['title'],
                'release_date' => $tmdb_movie['release_date'],
                'runtime' => $tmdb_movie['runtime'],
                'lang' => $tmdb_movie['original_language'],
                'video_format' => 'HD',
                'is_public' => false,
                'slug' => str()->slug($tmdb_movie['title']),
                'rating' => $tmdb_movie['vote_average'],
                'poster_path' => $tmdb_movie['poster_path'],
                'backdrop_path' => $tmdb_movie['backdrop_path'],
                'overview' => $tmdb_movie['overview']
            ]);

            $tmdb_genres = $tmdb_movie['genres'];
            $tmdb_genres_ids = collect($tmdb_genres)->pluck('id');
            $genres = Genre::whereIn('tmdb_id', $tmdb_genres_ids)->get();
            $created_movies->genres()->attach($genres);
            return  back()->with('success', 'successfully created movies');
        }
        return back()->with('error', 'API error');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $Movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return Inertia::render('Admin/Movies/Edit', ['movie' => $movie]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $this->validate($request, [
            'title' => 'required|string',
            'runtime' => 'required|numeric|integer',
            'lang' => 'required|string|max:2',
            'format' => 'required|string',
            'rating' => 'required|numeric',
            'poster_path' => 'required|string',
            'backdrop' => 'required|string',
            'overview' => 'required|string',
            'is_public' => 'required|boolean',
        ]);

        $movie->fill($validated)->save();
        return to_route('admin.movies.index')->with('success', 'Successfully Created Movie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if ($movie) {
            $movie->genres()->sync([]);
            $movie->delete();
            return back()->with('success', 'Successfully Deleted Movie');
        }
    }
}
