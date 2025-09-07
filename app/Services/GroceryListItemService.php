<?php

namespace App\Services;

use App\Models\GroceryList;
use App\Models\GroceryListItem;
use Illuminate\Support\Facades\Auth;

class GroceryListItemService
{


    public function updateGroceryListItem($id, array $data)
    {
        $item = GroceryListItem::findOrFail($id);
        $user = Auth::user();
//        checking if item was purchased
        if($data['purchased'])
        {
            $data['purchased_by'] = $user->id;
        }

        // Only update the keys present in $data
        $item->fill($data);
        $item->save();
        return $item;
    }
    public function hasPendingItems($groceryListId)
    {
        // query to check if anything comes back
        return GroceryListItem::where('grocery_list_id', $groceryListId)
            ->where('purchased' , false)
            ->exists();
    }
    public function deleteGroceryListItem($id)
    {
        $item = GroceryListItem::findOrFail($id);

        return $item->delete();
    }

    public function completeGroceryList($id)
    {
        $groceryList = GroceryList::findOrFail($id);
        $groceryList->update(['status' => 'Completed']);
    }

    public function calculateItemTotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }
    public function calculateTotalShopping($total , $newAmount): float
    {

        return round($total + $newAmount, 2);
    }
//this will update the grand total each time you shop, so no additonal function needed
    public function updateGrandTotalList($listId, $newTotal)
    {
        $list = GroceryList::findOrFail($listId);
        $grandTotal = $list->grand_total + $newTotal;
        $list->grand_total = $grandTotal;
        $list->save();
    }






}
