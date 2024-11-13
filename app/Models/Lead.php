<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    publi
}
