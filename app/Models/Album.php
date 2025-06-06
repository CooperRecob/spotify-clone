<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;
use App\Models\Track;

class Album extends Model
{
    protected $fillable = ['title', 'artist_id'];
    //
    public function artist() {
        return $this->belongsTo(Artist::class);
    }
    public function tracks() {
        return $this->hasMany(Track::class);
    }

}
