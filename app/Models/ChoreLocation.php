<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoreLocation extends Model
{
    use HasFactory;



    public function chores()
    {
        return $this->hasMany(Chore::class, 'location_id');
    }

    public function actions()
    {
        return $this->belongsToMany(ChoreAction::class, 'action_location', 'location_id', 'action_id');
    }

}
