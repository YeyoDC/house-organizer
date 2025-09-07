<?php

namespace App\Http\Controllers;

use App\Models\GroceryItem;
use App\Services\GroceryItemService;
use Illuminate\Http\Request;

class GroceryItemController extends Controller
{

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request, GroceryItemService $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user = $request->user();

        $item = $service->addGroceryItem(
            $validated['name'],
            $validated['category_id'],
            $user->id,
            $user->household_id
        );

        return redirect()->back()->with('success', 'Grocery Item added successfully.');
    }
    public function update(Request $request, GroceryItemService $service)
    {
        $data = $request->validate([
            'id' => 'required|exists:grocery_items,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
    }
    public function destroy($groceryItemId, GroceryItemService $service)
    {
        $deleted =  $service->deleteGroceryItem($groceryItemId);
        if ($deleted) {
            return redirect()->back()->with('success', 'Item deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete item.');
        }
    }
}
