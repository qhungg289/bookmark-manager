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
        $sortingOrder = $request->query('sort');

        $folders = match ($sortingOrder) {
            'name_asc' => $request->user()->folders()->with('bookmarks')->orderBy('name', 'asc')->get(),
            'name_desc' => $request->user()->folders()->with('bookmarks')->orderBy('name', 'desc')->get(),
            'created_latest' => $request->user()->folders()->with('bookmarks')->latest()->get(),
            'created_oldest' => $request->user()->folders()->with('bookmarks')->oldest()->get(),
            default => $request->user()->folders()->with('bookmarks')->latest()->get(),
        };

        $bookmarks = match ($sortingOrder) {
            'name_asc' => $request->user()->bookmarks()->doesntHave('folder')->with('tags')->orderBy('name', 'asc')->get(),
            'name_desc' => $request->user()->bookmarks()->doesntHave('folder')->with('tags')->orderBy('name', 'desc')->get(),
            'created_latest' => $request->user()->bookmarks()->doesntHave('folder')->with('tags')->latest()->get(),
            'created_oldest' => $request->user()->bookmarks()->doesntHave('folder')->with('tags')->oldest()->get(),
            default => $request->user()->bookmarks()->doesntHave('folder')->with('tags')->latest()->get(),
        };

        $filter = $request->query('filter');

        if ($filter == 'bookmarks') {
            $folders = null;
        }

        if ($filter == 'folders') {
            $bookmarks = null;
        }

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
            $doc->loadHTML('<?xml encoding="UTF-8">' . $response->body());
            libxml_use_internal_errors($e);
            $name = $doc->getElementsByTagName('title')->item(0)->textContent;
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

            $tagsId = $createdTags->map(fn ($tag, $index) => $tag->id);
            $bookmark->tags()->attach($tagsId);
        }

        return redirect()->route('bookmarks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bookmark $bookmark)
    {
        $this->authorize('view', $bookmark);

        $bookmark->load('tags');

        return view('bookmarks.show', [
            'bookmark' => $bookmark
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bookmark $bookmark)
    {
        $bookmark->load('tags');

        $tagsName = $bookmark->tags->map(fn ($tag, $index) => $tag->name);
        $tags = $tagsName->join(',');

        return view('bookmarks.edit', [
            'bookmark' => $bookmark,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bookmark $bookmark, DOMDocument $doc)
    {
        $this->authorize('update', $bookmark);

        $validated = $request->validate([
            'name' => ['nullable', 'string'],
            'url' => ['required', 'url'],
            'tags' => ['nullable', 'string']
        ]);

        $name = $validated['name'];

        if (!isset($name)) {
            $response = Http::withOptions(['verify' => false])->get($validated['url']);
            $e = libxml_use_internal_errors(true);
            $doc->loadHTML('<?xml encoding="UTF-8">' . $response->body());
            libxml_use_internal_errors($e);
            $name = $doc->getElementsByTagName('title')->item(0)->textContent;
        }

        $bookmark->name = $name;
        $bookmark->url = $validated['url'];
        $bookmark->icon = 'https://icon.horse/icon/' . parse_url($validated['url'])['host'];
        $bookmark->save();

        $formTags = $validated['tags'] ? Str::of($validated['tags'])->explode(',') : collect();
        $createdTags = collect([]);

        if ($formTags->count() > 0) {
            foreach ($formTags as $tagName) {
                $tag = Tag::firstOrCreate([
                    'name' => $tagName,
                    'user_id' => $request->user()->id
                ]);

                $createdTags->push($tag);
            }
        }

        $tagsId = $createdTags->map(fn ($tag, $index) => $tag->id);
        $bookmark->tags()->sync($tagsId);

        return redirect()->route('bookmarks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookmark $bookmark)
    {
        $this->authorize('delete', $bookmark);

        $bookmark->tags()->detach();
        $bookmark->delete();

        return redirect()->route('bookmarks.index');
    }
}
