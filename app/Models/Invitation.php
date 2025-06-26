<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'invited_by',
        'email',
        'status',
        'expires_at'
    ];

    protected static function booted()
    {
        static::creating(function ($invitation) {
            // Only set expires_at if it's not already set
            if (!$invitation->expires_at) {
                $invitation->expires_at = Carbon::now()->addDays(7);
            }
        });
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function userInvited()
    {
        return User::where('email', $this->email)->first();
    }

}
