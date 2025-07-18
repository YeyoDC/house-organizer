<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'description',
    ];

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
       return $this->belongsTo(User::class, 'owner_id');
    }

    public function chores()
    {
        return $this->hasMany(Chore::class);
    }


    public function groceryLists()
    {
        return $this->hasMany(GroceryList::class);
    }
    public function stockItems()
    {
        return $this->hasMany(GroceryStock::class);
    }

}
