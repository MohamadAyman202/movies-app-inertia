<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Season;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TvShowController extends Controller
{
    public function index()
    {
        return Inertia::render('FrontEnd/TvShows/Index', [
            'tvShows' => TvShow::orderBy('created_at', 'DESC')->paginate(12),
        ]);
    }

    public function show(TvShow $tvShow)
    {
        $latest = Movie::orderBy('created_at', 'DESC')->take(9)->get();
        return Inertia::render('FrontEnd/TvShows/Show', [
            'tvShow' => $tvShow,
            'seasons' => $tvShow->seasons,
            'latest' => $latest,
        ]);
    }

    public function seasonShow(TvShow $tvShow, Season $season)
    {
        $latest = Movie::orderBy('created_at', 'DESC')->take(9)->get();
        return Inertia::render('FrontEnd/TvShows/Seasons/Show', [
            'tvShow' => $tvShow,
            'season' => $season,
            'episodes' => $season->episodes,
            'latest' => $latest
        ]);
    }
}
