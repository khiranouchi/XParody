<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    public function getUpdatedAtDate()
    {
        return $this->updated_at->format('Y/m/d');
    }
}
