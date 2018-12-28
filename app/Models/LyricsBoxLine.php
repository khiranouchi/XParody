<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LyricsBoxLine extends Model
{
    public $timestamps = false;

    /**
     * Subordinate relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getAllColumnNames()
    {
        return ['line_idx', 'lyrics_new', 'level', 'user_id'];
    }

    public static function getLevels()
    {
        return [1, 2, 3, 4, 5];
    }
    public static function getMaxLevel()
    {
        return 5;
    }
    public static function getAvailableMaxLevel($box_id)
    {
        if (LyricsBoxLine::where('box_id', $box_id)->where('level', 5)->exists()) {
            return 4;
        } else {
            return 5;
        }
    }
}
