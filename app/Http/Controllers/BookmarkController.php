<?php

namespace App\Http\Controllers;

use DOMDocument;
use App\Models\Bookmark;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $folders = $request->user()->folders()->with('bookmarks')->latest()->get();
        $bookmarks = $request->user()->bookmarks()->doesntHave('folder')->with('tags')->latest()->get();

        return view('bookmarks.index', [
            'folders' => $folders,
            'bookmarks' => $bookmarks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookmarks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DOMDocument $doc)
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string'],
            'url' => ['required', 'url'],
            'tags' => ['nullable']
        ]);

        $name = $validated['name'];

        if (!isset($name)) {
            $response = Http::withOptions(['verify' => false])->get($validated['url']);
            $e = libxml_use_internal_errors(true);
            $doc->loadHTML($response->body());
            libxml_use_internal_errors($e);
            $name = $doc->getElementsByTagName('title')->item(0)->nodeValue;
        }

        $bookmark = $request->user()->bookmarks()->create([
            'url' => $validated['url'],
            'name' => $name,
            'icon' => 'https://icon.horse/icon/' . parse_url($validated['url'])['host'],
        ]);

        if (isset($validated['tags'])) {
            $formTags = Str::of($validated['tags'])->explode(',');
            $createdTags = collect([]);

            foreach ($formTags as $tagName) {
                $tag = Tag::firstOrCreate([
                    'name' => $tagName,
                    'user_id' => $request->user()->id
                ]);

                $createdTags->push($tag);
            }

            foreach ($createdTags as $tag) {
                $bookmark->tags()->attach($tag->id);
            }
        }

        return redirect()->route('bookmarks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        //
    }
}
