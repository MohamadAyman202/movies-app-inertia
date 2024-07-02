<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EpisodeController extends Controller
{
    public function showEpisode(Episode $episode)
    {
        $latest = Episode::queryEpisodes($episode->slug)
            ->orderBy('created_at', 'DESC')->take(9)->get();
        return Inertia::render('FrontEnd/TvShows/Seasons/Episodes/Show', [
            'episode' => $episode,
            'latest' => $latest,
            'season' => $episode->season
        ]);
    }
}
