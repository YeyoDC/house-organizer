<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class ChoreOccurrence extends Model
{
    use HasFactory;
    protected $fillable = [
        'chore_id',
        'due_date',
        'assigned_to',
        'is_completed',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean',
    ];
    public function chore()
    {
        return $this->belongsTo(Chore::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function toggleCompletion()
    {
        $this->is_completed = !$this->is_completed;
        $this->completed_at = $this->is_completed ? now() : null;
        $this->save();
    }

    public function assignTo(?int $userId)
    {
        $this->assigned_to = $userId;
        $this->save();
    }

}
