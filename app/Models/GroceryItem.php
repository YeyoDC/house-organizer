<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'household_id',
        'created_by',
        'is_basic',
    ];
    public function category()
    {
        return $this->belongsTo(GroceryCategory::class);
    }
    public function listItems()
    {
        return $this->hasMany(GroceryListItem::class);
    }

    public function stockItems()
    {
        return $this->hasMany(GroceryStock::class);
    }

}
