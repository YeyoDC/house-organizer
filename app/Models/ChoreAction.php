<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoreAction extends Model
{
    use HasFactory;



    public function chores()
    {
        return $this->hasMany(Chore::class, 'action_id');
    }

    public function locations()
    {
        return $this->belongsToMany(ChoreLocation::class, 'action_location', 'action_id', 'location_id');
    }

}
