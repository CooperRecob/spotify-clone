<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Track;

class Playlist extends Model
{
    protected $fillable = ['name', 'user_id'];
    //
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function tracks() {
        return $this->belongsToMany(Track::class, 'playlist_track');
    }
}
