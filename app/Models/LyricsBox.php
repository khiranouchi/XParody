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

    public static function filterEmptyLyrics($lyrics_old)
    {
        if ($lyrics_old === '') {
            return '(empty)';
        } else {
            return $lyrics_old;
        }
    }
}
