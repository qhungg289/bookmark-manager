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

    Route::resource('/bookmarks', BookmarkController::class)->except(['create']);
    Route::resource('/folders', FolderController::class)->except(['index', 'create']);
    Route::resource('/tags', TagController::class)->only(['show']);
    Route::get('/search', SearchController::class)->name('search');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/{user}', 'show')->name('profiles.show');
        Route::get('/profile/{user}/edit', 'edit')->name('profiles.edit');
        Route::put('/profile/{user}/update', 'update')->name('profiles.update');
        Route::get('/profile/{user}/change-password', 'editPassword')->name('profiles.edit-password');
        Route::put('/profile/{user}/change-password', 'updatePassword')->name('profiles.update-password');
    });
});
