<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
    public function followUps()
    {
        return $this->hasMany(FollowUp::class);
    }

    
}
