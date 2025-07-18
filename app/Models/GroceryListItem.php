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

}
