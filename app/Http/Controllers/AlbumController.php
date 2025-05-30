<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artist;

class AlbumController extends Controller
{
    //
        public function index() {
        $albums = Album::with('artist')->get();
        return view('albums.index', compact('albums'));
    }

    public function create() {
        $artists = Artist::all();
        return view('albums.create', compact('artists'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id'
        ]);
        Album::create($request->only('title', 'artist_id'));
        return redirect()->route('albums.index');
    }

    public function show(Album $album) {
        $album->load('artist', 'tracks');
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album) {
        $artists = Artist::all();
        return view('albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album) {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id'
        ]);
        $album->update($request->only('title', 'artist_id'));
        return redirect()->route('albums.index');
    }

    public function destroy(Album $album) {
        $album->delete();
        return redirect()->route('albums.index');
    }
}
