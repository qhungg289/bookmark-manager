<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'folder_name' => ['required', 'string'],
        ]);

        $request->user()->folders()->create([
            'name' => $validated['folder_name'],
            'is_public' => $request->boolean('is_public')
        ]);

        return redirect()->route('bookmarks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Folder $folder)
    {
        $this->authorize('view', $folder);

        $folder->load('bookmarks', 'bookmarks.tags');

        return view('folders.show', [
            'folder' => $folder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Folder $folder)
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->doesntHave('folder')
            ->with('tags')
            ->latest()
            ->get();

        return view('folders.edit', [
            'folder' => $folder,
            'bookmarks' => $bookmarks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        $this->authorize('update', $folder);

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'bookmarks' => ['nullable', 'string']
        ]);

        $folder->name = $validated['name'];
        $folder->is_public = $request->boolean('is_public');
        $folder->save();

        $bookmarksId = Str::of($validated['bookmarks'])->explode(',');
        Bookmark::where('folder_id', $folder->id)->update(['folder_id' => null]);
        Bookmark::whereIn('id', $bookmarksId)->update(['folder_id' => $folder->id]);

        return redirect()->route('bookmarks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        $this->authorize('delete', $folder);

        $bookmarksBelongToFolder = $folder->bookmarks;
        foreach ($bookmarksBelongToFolder as $bookmark) {
            $bookmark->tags()->detach();
        }

        $folder->delete();

        return redirect()->route('bookmarks.index');
    }
}
