<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use getID3;

class ImportTracks extends Command
{
    protected $signature = 'tracks:import';
    protected $description = 'Import tracks from storage into the database';

    public function handle()
    {
        $base = storage_path('app/public/tracks');
$getID3 = new \getID3;

foreach (glob("$base/*", GLOB_ONLYDIR) as $folderPath) {
    $folderName = basename($folderPath); // e.g., "a night at the opera - Queen"

    if (!str_contains($folderName, ' - ')) {
        continue; // skip folders not matching expected format
    }

    [$albumName, $artistName] = array_map('trim', explode(' - ', $folderName, 2));
    $albumName = ucwords($albumName);
    $artistName = ucwords($artistName);

    $artist = \App\Models\Artist::firstOrCreate(['name' => $artistName]);
    $album = \App\Models\Album::firstOrCreate([
        'title' => $albumName,
        'artist_id' => $artist->id,
    ]);

    foreach (glob("$folderPath/*.mp3") as $file) {
        $info = $getID3->analyze($file);
        $filename = pathinfo($file, PATHINFO_FILENAME); // e.g., "Queen - Bohemian Rhapsody"

        // Strip artist prefix if present
        $filename = preg_replace('/^\d+\s*/', '', $filename); // remove leading numbers
$title = preg_replace('/^' . preg_quote($artistName, '/') . '\s*-\s*/i', '', $filename);

        $duration = isset($info['playtime_seconds']) ? (int)$info['playtime_seconds'] : 0;

        $relativePath = str_replace(storage_path('app/public/'), '', $file);
        $relativePath = str_replace('\\', '/', $relativePath);

        \App\Models\Track::updateOrCreate(
            ['title' => $title, 'album_id' => $album->id],
            ['duration' => $duration, 'file_path' => $relativePath]
        );
    }
}
        $this->info('Tracks imported successfully.');
    }
}

