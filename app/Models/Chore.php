<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chore extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    protected $fillable = [
        'action_id',
        'location_id',
        'start_date',
        'end_date',
        'recurrence',
        'notes',
        'created_by',
        'household_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function household()
    {
        return $this->belongsTo(Household::class,'household_id');
    }

    public function action()
    {
        return $this->belongsTo(ChoreAction::class, 'action_id');
    }

    public function location()
    {
        return $this->belongsTo(ChoreLocation::class, 'location_id');
    }


    public function occurrences()
    {
        return $this->hasMany(ChoreOccurrence::class, 'chore_id');
    }

}
