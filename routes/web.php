<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\PlaylistController;

Route::middleware(['auth'])->group(function () {
    Route::resource('artists', ArtistController::class);
    Route::resource('albums', AlbumController::class);
    Route::resource('tracks', TrackController::class);
    Route::resource('playlists', PlaylistController::class);
    Route::post('playlists/{playlist}/add-track', [PlaylistController::class, 'addTrack'])->name('playlists.addTrack');
    Route::delete('playlists/{playlist}/remove-track/{track}', [PlaylistController::class, 'removeTrack'])->name('playlists.removeTrack');
});

require __DIR__.'/auth.php';
