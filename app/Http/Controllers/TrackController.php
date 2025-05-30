<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Album;

class TrackController extends Controller
{
    //
    public function index() {
        $tracks = Track::with('album.artist')->get();
        return view('tracks.index', compact('tracks'));
    }

    public function create() {
        $albums = Album::with('artist')->get();
        return view('tracks.create', compact('albums'));
    }

    public function store(Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
        'duration' => 'required|integer',
        'album_id' => 'required|exists:albums,id',
        'audio_file' => 'required|file|mimes:mp3,wav,ogg'
    ]);

    $track = Track::create($request->only('title', 'duration', 'album_id'));

    if ($request->hasFile('audio_file')) {
        $path = $request->file('audio_file')->store('tracks', 'public');
        $track->file_path = $path;
        $track->save();
    }

    return redirect()->route('tracks.index');
}


    public function show(Track $track) {
        $track->load('album.artist');
        return view('tracks.show', compact('track'));
    }

    public function edit(Track $track) {
        $albums = Album::with('artist')->get();
        return view('tracks.edit', compact('track', 'albums'));
    }

    public function update(Request $request, Track $track) {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer',
            'album_id' => 'required|exists:albums,id'
        ]);
        $track->update($request->only('title', 'duration', 'album_id'));
        return redirect()->route('tracks.index');
    }

    public function destroy(Track $track) {
        $track->delete();
        return redirect()->route('tracks.index');
    }
}
