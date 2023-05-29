<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
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
            'comment' => ['required', 'string', 'max:255'],
            'folder_id' => ['required', 'integer']
        ]);

        $request->user()->comments()->create([
            'content' => $validated['comment'],
            'folder_id' => $validated['folder_id']
        ]);

        return redirect()->route('folders.show', ['folder' => $validated['folder_id']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', [
            'comment' => $comment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:255']
        ]);

        $comment->content = $validated['comment'];
        $comment->save();

        return redirect()->route('folders.show', ['folder' => $comment->folder->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $folderId = $comment->folder->id;
        $comment->delete();

        return redirect()->route('folders.show', ['folder' => $folderId]);
    }
}
