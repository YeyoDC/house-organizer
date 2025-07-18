<?php

namespace App\Http\Controllers;

use App\Services\GroceryStockService;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;

class GroceryStockController extends Controller
{
    //



    public function index()
    {

    }

    public function store(Request $request, GroceryStockService $groceryStockService )
    {

    }

    public function destroy($stockId, GroceryStockService $groceryStockService )
    {
        $groceryStockService->deleteStockItem($stockId);
        return redirect()->back()->with('success', 'Stock item deleted');
    }

    public function update($stockItemId, Request $request, GroceryStockService $groceryStockService)
    {
        try {
            // Validate only the fields that may come in the request
            $data = $request->only(['quantity', 'brand', 'notes', 'expiry_date']); // add all allowed updatable fields here

            // Optionally validate values here or rely on FormRequest for more complex validation

            $updated = $groceryStockService->updateStockItem($stockItemId, $data);

            if (!$updated) {
                session()->flash('error', 'Stock item not found or could not be updated.');
                return;
            }

            session()->flash('success', 'Stock item updated successfully.');

        } catch (\Exception $e) {
            \Log::error("Failed to update stock item ID {$stockItemId}: " . $e->getMessage());
            session()->flash('error', 'Failed to update stock item. Please try again later.');
        }
    }



}
