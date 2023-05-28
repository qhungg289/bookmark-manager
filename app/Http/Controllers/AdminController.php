<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Folder;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminController extends Controller
{
    public function index()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $bookmarksCount = Bookmark::count();
        $foldersCount = Folder::count();
        $usersCount = User::count();
        $tagsCount = Tag::count();

        $bookmarksChartOptions = [
            'chart_title' => 'Bookmarks by days',
            'chart_type' => 'bar',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Bookmark',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_color' => '251, 146, 60'
        ];
        $bookmarksChart = new LaravelChart($bookmarksChartOptions);

        $foldersChartOptions = [
            'chart_title' => 'Folders by days',
            'chart_type' => 'line',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Folder',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_color' => '74, 222, 128'
        ];
        $foldersChart = new LaravelChart($foldersChartOptions);

        $usersChartOptions = [
            'chart_title' => 'New users by days',
            'chart_type' => 'bar',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_color' => '96, 165, 250'
        ];
        $usersChart = new LaravelChart($usersChartOptions);

        $tagsChartOptions = [
            'chart_title' => 'Tags name',
            'chart_type' => 'pie',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\Tag',
            'group_by_field' => 'name',
            'chart_color' => '232, 121, 249'
        ];
        $tagsChart = new LaravelChart($tagsChartOptions);

        return view('admin.index', [
            'bookmarksCount' => $bookmarksCount,
            'foldersCount' => $foldersCount,
            'usersCount' => $usersCount,
            'tagsCount' => $tagsCount,
            'bookmarksChart' => $bookmarksChart,
            'foldersChart' => $foldersChart,
            'usersChart' => $usersChart,
            'tagsChart' => $tagsChart
        ]);
    }

    public function getAllBookmarks()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $bookmarks = Bookmark::all();

        return view('admin.bookmarks', [
            'bookmarks' => $bookmarks,
        ]);
    }

    public function getAllFolders()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $folders = Folder::with('bookmarks')->get();

        return view('admin.folders', [
            'folders' => $folders,
        ]);
    }

    public function getAllUsers()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $users = User::all();

        return view('admin.users', [
            'users' => $users,
        ]);
    }

    public function getAllTags()
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $tags = Tag::all();

        return view('admin.tags', [
            'tags' => $tags,
        ]);
    }
}
