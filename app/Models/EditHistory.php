<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditHistory extends Model
{
    /**
     * Subordinate relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    const EDIT_TYPE_SONG = 0;
    const EDIT_TYPE_LYRICS_BOX = 1;
    const EDIT_TYPE_LYRICS_BOX_LINE = 2;
    const EDIT_TYPE_SONG_IMPORT = 3;
}
