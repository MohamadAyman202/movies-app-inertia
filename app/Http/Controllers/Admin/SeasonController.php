<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TvShow $tvShow)
    {
        $perPage = FacadesRequest::input('per_page') ?: 5;

        $seasons = season::where('tv_show_id', $tvShow->id)
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })->paginate($perPage)->withQueryString();

        $filters = FacadesRequest::only(['search', 'per_page']);

        return Inertia::render('Admin/TvShow/Seasons/Index', [
            'seasons' =>  $seasons,
            'filters' => $filters,
            'tvShow' => $tvShow
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/TvShow/Seasons/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $tv_show = TvShow::findOrFail($id);
        $season_number = $request->season_number;
        $season = $tv_show->seasons()->where('season_number', $season_number)->exists();
        if ($season) return back()->with('error', 'Season Exists');

        $TMDB_ENDPOINT = env('TMDB_ENDPOINT');
        $TMDB_ACCESS_TOKEN = env('TMDB_ACCESS_TOKEN');
        $tmdb_season = Http::withToken($TMDB_ACCESS_TOKEN)
            ->accept('application/json')
            ->get("$TMDB_ENDPOINT/tv/{$tv_show->tmdb_id}/season/$season_number?language=en-US");

        if ($tmdb_season->successful()) {
            $tmdb_season_json = $tmdb_season->json();
            Season::create([
                'tmdb_id' => $tmdb_season_json['id'],
                'name' => $tmdb_season_json['name'],
                'slug' => $tmdb_season_json['name'],
                'tv_show_id' => $tv_show->id,
                'season_number' => $tmdb_season_json['season_number'],
                'poster_path' => $tmdb_season_json['poster_path'],
            ]);

            return back()->with('success', 'Season created successfully');
        }
        return  back()->with('error', 'Api error creating');
    }

    /**
     * Display the specified resource.
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $tv_show_id, string $season_id)
    {
        $season = Season::findOrFail($season_id);
        return Inertia::render('Admin/TvShow/Seasons/Edit', ['season' => $season, 'tvShowId' => $tv_show_id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $tv_show_id, string $season_id)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'poster_path' => 'required|string'
        ]);
        $season = Season::findOrFail($season_id);
        $season->fill($validated)->save();
        return to_route('admin.season.index', $tv_show_id)->with('success', 'successfully updated the season');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $season = Season::findOrFail($id);
        if ($season) {
            $season->delete();
            return back()->with('success', 'Successfully removed Season');
        }
        return back()->with('error', 'error not removed season');
    }
}
