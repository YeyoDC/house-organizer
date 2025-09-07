<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroceryListItem extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'grocery_list_id',
            'grocery_item_id',
            'quantity',
            'added_manually',
            'purchased',
            'purchased_by',
            'unit_price',
            'total_price',
            'purchased_at',
            'expires_at',
            'brand',
            'notes',
        ];
    public function groceryItem()
    {
        return $this->belongsTo(GroceryItem::class);
    }
    public function groceryList()
    {
        return $this->belongsTo(GroceryList::class);
    }
    public function purchasedByUser()
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }

}
