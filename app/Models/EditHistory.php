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

    public function getCreatedAtDateTime()
    {
        return $this->created_at->format('y/m/d H:i:s');
    }
    public function getEditTypeLabel()
    {
        switch ($this->edit_type) {
        case self::EDIT_TYPE_SONG:
            return 'value_edit_type_song';
        case self::EDIT_TYPE_LYRICS_BOX:
            return 'value_edit_type_lyrics_box';
        case self::EDIT_TYPE_LYRICS_BOX_LINE:
            return 'value_edit_type_lyrics_box_line';
        case self::EDIT_TYPE_SONG_IMPORT:
            return 'value_edit_type_song_import';
        }
    }
}
