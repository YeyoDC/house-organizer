<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'phone',
        'profile_picture',
        // Add any other columns you have in your `profiles` table
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
