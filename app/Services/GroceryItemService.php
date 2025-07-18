<?php

namespace App\Services;

use App\Models\GroceryItem;

class GroceryItemService
{
    public function addGroceryItem($name, $categoryId, $createdBy, $householdId, $isBasic = null)
    {
      $groceryItem =  GroceryItem::create([
            'name' => $name,
            'category_id' => $categoryId,
            'household_id' => $householdId,
            'created_by' => $createdBy,
        ]);

      return $groceryItem;
    }

    public function deleteGroceryItem($id)
    {
        $groceryItem = GroceryItem::findOrFail($id);
        $groceryItem->delete();

    }

    public function updateGroceryItem($id, array $data)
    {
        $item = GroceryItem::findOrFail($id);

        // Only update keys that are present
        $item->fill($data);
        $item->save();

        return $item;
    }

}
