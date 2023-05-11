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
                ->where('url', 'like', "%$searchString%")
                ->orWhere('name', 'like', "%$searchString%")
                ->get();

            return view('search', [
                'bookmarks' => $bookmarks,
                'searchString' => $searchString
            ]);
        }

        return view('search');
    }
}
