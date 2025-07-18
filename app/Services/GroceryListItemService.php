<?php

namespace App\Services;

use App\Models\GroceryListItem;

class GroceryListItemService
{


    public function updateGroceryListItem($id, array $data)
    {
        $item = GroceryListItem::findOrFail($id);

        // Only update the keys present in $data
        $item->fill($data);
        $item->save();

        return $item;
    }

}
