<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function getAllColumnNames()
    {
        return ['name_old', 'name_old_ruby', 'name_new', 'name_new_ruby'];
    }
    
    public function getUpdatedAtDate()
    {
        return $this->updated_at->format('Y/m/d');
    }
}
