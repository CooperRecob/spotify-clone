<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Track;

class PlaylistController extends Controller
{
    //
    use AuthorizesRequests;
    public function index() {
        $playlists = Playlist::with('tracks')->where('user_id', Auth::id())->get();
        return view('playlists.index', compact('playlists'));
    }

    public function create() {
        return view('playlists.create');
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255']);
        Playlist::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('playlists.index');
    }

    public function show(Playlist $playlist) {
        $this->authorize('view', $playlist);
        $playlist->load('tracks.album.artist');
        return view('playlists.show', compact('playlist'));
    }

    public function edit(Playlist $playlist) {
        $this->authorize('update', $playlist);
        return view('playlists.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist) {
        $this->authorize('update', $playlist);
        $request->validate(['name' => 'required|string|max:255']);
        $playlist->update($request->only('name'));
        return redirect()->route('playlists.index');
    }

    public function destroy(Playlist $playlist) {
        $this->authorize('delete', $playlist);
        $playlist->delete();
        return redirect()->route('playlists.index');
    }

    public function addTrack(Request $request, Playlist $playlist) {
        $this->authorize('update', $playlist);
        $request->validate(['track_id' => 'required|exists:tracks,id']);
        $playlist->tracks()->syncWithoutDetaching($request->track_id);
        return back();
    }

    public function removeTrack(Playlist $playlist, Track $track) {
        $this->authorize('update', $playlist);
        $playlist->tracks()->detach($track->id);
        return back();
    }
}
