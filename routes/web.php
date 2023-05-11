<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->user()) {
        return redirect()->route('bookmarks.index');
    }

    return view('index');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/login', 'auth.login')->name('login');

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('/bookmarks', BookmarkController::class);
    Route::resource('/folders', FolderController::class);
    Route::resource('/tags', TagController::class);
    Route::get('/search', SearchController::class)->name('search');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'show')->name('profiles.show');
    });
});
