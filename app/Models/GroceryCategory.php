<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryCategory extends Model
{
    use HasFactory;

    public function groceryItems()
    {
        return $this->hasMany(GroceryItem::class);
    }
}
