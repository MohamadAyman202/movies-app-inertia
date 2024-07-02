<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Inertia\Inertia;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $prePage = FacadesRequest::input('prePage') ?: 15;
        return Inertia::render('Admin/Tags/Index', [
            'tags' => Tag::when(
                FacadesRequest::input('search'),
                function ($query, $search) {
                    $query->where('tag_name', 'like', "%{$search}%");
                }
            )->orderBy('created_at', 'DESC')
                ->paginate($prePage, ['tag_name', 'slug'])->withQueryString(),

            'filters' => FacadesRequest::only(['search', 'prePage'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Tags/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $data['slug'] = str()->slug($data['tag_name']);

        $slug_tag_count = Tag::where('slug', $data['slug'])->count();

        if ($slug_tag_count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        Tag::create($data);

        return to_route('admin.tags.index')->with('success', 'Successfully Created Tags');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        return Inertia::render('Admin/Tags/Edit', [
            'tag' => Tag::where('slug', $slug)->first(['tag_name', 'slug']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $data = $request->all();
        $tag = Tag::where('slug', $slug);

        $data['slug'] = str()->slug($data['tag_name']);

        if ($tag->count() >= 1) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        $tag->first()->fill($data)->save();

        return to_route('admin.tags.index')->with('success', 'Successfully Updated Tags');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag) {
            $tag->delete();
            return to_route('admin.tags.index')->with('success', 'Successfully Deleted Tags');
        }
    }
}
