<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $searchString = $request->query('q');

        if (isset($searchString)) {
            $bookmarks = $request->user()
                ->bookmarks()
                ->where(function ($query) use ($searchString) {
                    $query->where('url', 'like', "%$searchString%")
                        ->orWhere('name', 'like', "%$searchString%");
                })
                ->get();

            $folders = $request->user()
                ->folders()
                ->where('name', 'like', "%$searchString%")
                ->get();

            $tags = $request->user()
                ->tags()
                ->where('name', 'like', "%$searchString%")
                ->get();

            return view('search', [
                'bookmarks' => $bookmarks,
                'folders' => $folders,
                'tags' => $tags,
                'searchString' => $searchString
            ]);
        }

        return view('search');
    }
}
