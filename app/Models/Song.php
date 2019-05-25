<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * Subordinate relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator_user()
    {
        return $this->belongsTo('App\User');
    }

    public function getAllColumnNames()
    {
        return ['name_old', 'name_old_ruby', 'name_new', 'name_new_ruby', 'is_complete', 'access_level'];
    }
    
    public function getUpdatedAtDate()
    {
        return $this->updated_at->format('y/m/d');
    }
    public function getUpdatedAtDateTime()
    {
        return $this->updated_at->format('Y/m/d H:i:s');
    }
    public function getCreatedAtDateTime()
    {
        return $this->created_at->format('y/m/d H:i:s');
    }
}
