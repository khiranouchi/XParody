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

    /*
     * Return if request user can access according to song's creator_user_id & access_level.
     *
     * @param  $request_user_id
     * @param  $target_level  restrict access when song's access level >= this level
     * @return mixed
     */
    public function isAccessible($request_user_id, $target_level)
    {
        return !isset($this->access_level) or $this->access_level < $target_level or !isset($this->creator_user) or $request_user_id === $this->creator_user_id;
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
