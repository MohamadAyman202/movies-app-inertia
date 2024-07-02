<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prePage = FacadesRequest::input('prePage') ?: 5;
        return Inertia::render('Admin/Genres/Index', [
            'genres' => Genre::when(
                FacadesRequest::input('search'),
                function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                }
            )->orderBy('created_at', 'DESC')
                ->paginate($prePage)->withQueryString(),

            'filters' => FacadesRequest::only(['search', 'prePage'])
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
        $tmdb_end_point = env('TMDB_ENDPOINT');
        $TMDB_ACCESS_TOKEN = env('TMDB_ACCESS_TOKEN');

        $tmdb_genres = Http::withToken($TMDB_ACCESS_TOKEN)
            ->accept('application/json')
            ->get("$tmdb_end_point/genre/movie/list");

        if ($tmdb_genres->successful()) {
            $tmdbGenres = $tmdb_genres->json();

            foreach ($tmdbGenres['genres'] as $tmdbGenre) {
                $genre = Genre::where('tmdb_id', $tmdbGenre['id'])->first();

                if (!$genre) {
                    Genre::create([
                        'tmdb_id' => $tmdbGenre['id'],
                        'title' => $tmdbGenre['name'],
                        'slug' => str()->slug($tmdbGenre['name']),
                    ]);

                }

            }
            return to_route('admin.genres.index')->with('success', 'Successfully Created Genres');
        }
        return redirect()->route('admin.casts.create')->with('error', 'API Error');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $genre = Genre::where('slug', $slug)->first();
        return Inertia::render('Admin/Genres/Edit', ['genre' => $genre]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $genre->fill($request->all())->save();
        return to_route('admin.genres.index')->with('success', 'successfully updated genre');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        if ($genre) {
            $genre->delete();
            return back()->with('success', 'successfully removed genre');
        }
    }
}
