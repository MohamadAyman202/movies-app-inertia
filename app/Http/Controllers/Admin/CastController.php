<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = FacadesRequest::input('perPage') ?: 5;
        return Inertia::render('Admin/Casts/Index', [
            'casts' => Cast::when(FacadesRequest::input('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })->paginate($perPage)->withQueryString(),

            'filters' => FacadesRequest::only(['search', 'prePage'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Casts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cast = Cast::where('tmdb_id', $request->tmdb_id)->first();

        if ($cast) {
            return to_route('admin.casts.create')->with('error', 'Cast Exists');
        }

        $tmdb_endpoint = env('TMDB_ENDPOINT');
        $tmdb_api_key = env('TMDB_SECRET_KEY');

        $tmdb_cast = Http::get("$tmdb_endpoint/person/$request->tmdb_id?api_key=$tmdb_api_key");
        if ($tmdb_cast->successful()) {
            Cast::create([
                'tmdb_id' => $tmdb_cast['id'],
                'name'    => $tmdb_cast['name'],
                'slug'    => str()->slug($tmdb_cast['name']),
                'poster_path' => $tmdb_cast['profile_path']
            ]);
            return redirect()->route('admin.casts.index')->with('success', 'Successfully Created CAST');
        } else {
            return redirect()->route('admin.casts.create')->with('error', 'API Error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cast $cast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $cast = Cast::where('slug', $slug)->first();

        return Inertia::render('Admin/Casts/Edit', ['cast' => $cast]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $validator = $this->validate($request, [
            'name' => '|required|string',
            'poster_path' => 'required|string',
        ]);

        $cast = Cast::where('slug', $slug)->first();

        $cast->fill($validator)->save();

        return to_route('admin.casts.index')->with('success', 'Success updated cast');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $cast = Cast::where('slug', $slug)->first();

        if ($cast) {
            $cast->delete();
            return to_route('admin.casts.index')->with('success', 'Success deleted cast');
        }
    }
}
