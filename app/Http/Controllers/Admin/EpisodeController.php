<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TvShow $tvShow, Season $season)
    {
        $perPae = FacadesRequest::input('per_page') ?: 5;

        $episodes = Episode::where("season_id", $season->id)
            ->when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })->paginate($perPae)->withQueryString();

        $filters = FacadesRequest::only(['per_page', 'search']);

        return Inertia::render('Admin/TvShow/Seasons/Episodes/Index', [
            'episodes' => $episodes,
            'filters' => $filters,
            'tvShow' => $tvShow,
            'season' => $season
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
    public function store(Request $request, TvShow $tvShow, Season $season)
    {
        $episode = $season->episodes()->where('episode_number', $request->episode_number)->exists();

        if ($episode) return back()->with('error', 'Episode Exists');

        $TMDB_ENDPOINT = env('TMDB_ENDPOINT');
        $TMDB_ACCESS_TOKEN = env('TMDB_ACCESS_TOKEN');

        $tmdb_episode = Http::withToken($TMDB_ACCESS_TOKEN)
            ->accept('application/json')->get("$TMDB_ENDPOINT/tv/$tvShow->tmdb_id/season/$season->season_number/episode/$request->episode_number");

        if ($tmdb_episode->successful()) {
            Episode::query()->create([
                'tmdb_id' => $tmdb_episode['id'],
                'season_id' => $season->id,
                'name' => $tmdb_episode['name'],
                'episode_number' => $tmdb_episode['episode_number'],
                'is_public' => false,
                'visits' => 1,
                'slug' => str()->slug($tmdb_episode['name']),
                'overview' => $tmdb_episode['overview']
            ]);

            return back()->with('success', 'Successfully created a new episode');
        }
        return back()->with("error", 'API Error');
    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TvShow $tvShow, Season $season, string $id)
    {
        $episode = Episode::findOrFail($id);
        return Inertia::render('Admin/TvShow/Seasons/Episodes/Edit', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episode' => $episode
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TvShow $tvShow, Season $season, string $id)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'overview' => 'required|string',
            'is_public' => 'required|boolean'
        ]);

        $episode = Episode::findOrFail($id);

        $episode->fill($validated)->save();

        return to_route('admin.episodes.index', [$tvShow->id, $season->id])
            ->with('success', 'Successfully Updated episode');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $episode = Episode::findOrFail($id);
        if ($episode) {
            $episode->delete();
            return back()->with('success', 'Successfully deleted episode');
        }
    }
}
