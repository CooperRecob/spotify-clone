<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Album;

class Track extends Model
{
    protected $fillable = ['title', 'duration', 'album_id', 'file_path'];

    //
    public function album() {
        return $this->belongsTo(Album::class);
    }
}
