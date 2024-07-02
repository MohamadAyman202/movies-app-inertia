<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CastController extends Controller
{
    public function index()
    {
        return Inertia::render('FrontEnd/Casts/Index', [
            'casts' => Cast::orderBy('created_at', 'desc')->paginate(12),
        ]);
    }

    public function show(Cast $cast)
    {
        return Inertia::render('FrontEnd/Casts/Show', [
            'cast' => $cast,
            'movies' => $cast->movies()->paginate(12),
        ]);
    }
}
