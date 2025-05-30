<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artist;

class ArtistController extends Controller
{
    //
    public function index()
    {
        $artists = Artist::all();
        return view('artists.index', compact('artists'));
    }

    public function create()
    {
        return view('artists.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Artist::create($request->only('name'));
        return redirect()->route('artists.index');
    }

    public function show(Artist $artist)
    {
        return view('artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $request->validate(['name' => 'required']);
        $artist->update($request->only('name'));
        return redirect()->route('artists.index');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();
        return redirect()->route('artists.index');
    }
}
