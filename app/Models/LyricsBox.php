<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LyricsBox extends Model
{
    public $timestamps = false;

    public function getAllColumnNames()
    {
        return ['box_idx', 'lyrics_old'];
    }
}
