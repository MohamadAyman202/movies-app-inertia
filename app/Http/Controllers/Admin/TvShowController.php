<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class TvShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prePage = FacadesRequest::input('prePage') ?: 5;

        $tv_shows = TvShow::when(
            FacadesRequest::input('search'),
            function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            }
        )->orderBy('created_at', 'DESC')
            ->paginate($prePage)->withQueryString();

        return Inertia::render('Admin/TvShow/Index', [
            'tvShows' => $tv_shows,

            'filters' => FacadesRequest::only(['search', 'prePage'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/TvShow/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $TMDB_ENDPOINT = env('TMDB_ENDPOINT');
        $TMDB_ACCESS_TOKEN = env('TMDB_ACCESS_TOKEN');

        $tvShow = TvShow::where('tmdb_id', $request->tv_tmdb_id)->first();

        if ($tvShow) return back()->with('success', 'tv show exists');

        $tv_show_tmdb = Http::withToken($TMDB_ACCESS_TOKEN)
            ->accept('application/json')
            ->get("$TMDB_ENDPOINT/tv/{$request->tv_tmdb_id}?language=en-US");

        if ($tv_show_tmdb->successful()) {
            $tv_show_json = $tv_show_tmdb->json();

            TvShow::create([
                'tmdb_id' => $tv_show_json['id'],
                'name' => $tv_show_json['name'],
                'slug' => str()->slug($tv_show_json['name']),
                'created_year' => $tv_show_json['first_air_date'],
                'poster_path' => $tv_show_json['poster_path'],
            ]);

            return to_route('admin.tv-show.index')->with('success', 'Successfully Created tv-show');
        }
        return back()->with('error', 'Error creating tv-show (Api Error)');
    }

    /**
     * Display the specified resource.
     */
    public function show(TvShow $tvShow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TvShow $tvShow)
    {
        return Inertia::render('Admin/TvShow/Edit', ['tvShow' => $tvShow]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TvShow $tvShow)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'poster_path' => 'required|string'
        ]);

        $tvShow->fill($validated)->save();

        return to_route('admin.tv-show.index')->with('success', 'successfully updated tv');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TvShow $tvShow)
    {
        if ($tvShow) {
            $tvShow->delete();
            return back()->with('success', 'successfully deleted tv');
        }
        return back()->with('success', 'Error Not Successfully Deleted Tv!');
    }
}
