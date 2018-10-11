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
}
