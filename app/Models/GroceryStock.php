<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'grocery_item_id',
        'quantity',
        'household_id',
        'expiry_date',
        'unit_price',
        'total_price',
        'location',
        'brand',
        'purchased_by'
    ];

    public function groceryItem()
    {
        return $this->belongsTo(GroceryItem::class, 'grocery_item_id');
    }

    public function household()
    {
        return $this->belongsTo(Household::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
