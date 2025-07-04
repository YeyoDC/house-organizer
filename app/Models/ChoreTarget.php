<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoreTarget extends Model
{
    use HasFactory;

    public function chores()
    {
        return $this->hasMany(Chore::class, 'location_id');
    }
}
