<?php

namespace App\Services;

use App\Models\GroceryStock;

class GroceryStockService
{

    public function getCurrentStockForUser(int $userId)
    {
        return GroceryStock::with('groceryItem') // Eager-load related item info
        ->where('user_id', $userId)
            ->whereNull('household_id')
            ->orderBy('location')
            ->orderBy('expiry_date')
            ->get();
    }

    public function getCurrentStockForHousehold(int $householdId)
    {
        return GroceryStock::with('groceryItem')
            ->where('household_id', $householdId)
            ->whereNull('user_id')
            ->orderBy('location')
            ->orderBy('expiry_date')
            ->get();
    }

    public function getLowStockForUser(int $userId, int $threshold = 1)
    {
        return GroceryStock::with('groceryItem')
            ->where('user_id', $userId)
            ->where('quantity', '<=', $threshold)
            ->get();
    }

    public function getExpiringSoon(int $userId, int $days = 3)
    {
        return GroceryStock::with('groceryItem')
            ->where('user_id', $userId)
            ->whereDate('expiry_date', '<=', now()->addDays($days))
            ->get();
    }
    // method to delete all or just individual stock item
    public function deleteStockItem($stockItemId)
    {
        $item = GroceryStock::findOrFail($stockItemId);
        $item->delete();
        session()->flash('success', 'Item deleted successfully.');
    }
    public function updateStockItem($stockItemId, array $data)
    {
        $stockItem = GroceryStock::find($stockItemId);

        if (!$stockItem) {
            return false;
        }

        // Update only passed fields
        $stockItem->fill($data);

        return $stockItem->save();
    }
    public function addStock(array $attributes): GroceryStock
    {
        return GroceryStock::create($attributes);
    }

}
