<?php

namespace App\Livewire\Groceries;

use App\Models\GroceryListItem;
use App\Models\GroceryList;
use App\Services\GroceryListItemService;
use App\Services\GroceryStockService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShoppingList extends Component
{
    public $groceryListId;
    public $listItems = [];
    public $view = 'household';

    protected ?GroceryListItemService $service = null;

    public function mount()
    {
        $this->loadShoppingList();
    }

    /**
     * Lazily initialize the GroceryListItemService.
     */
    protected function getService(): GroceryListItemService
    {
        if (!$this->service) {
            $this->service = app(GroceryListItemService::class);
        }
        return $this->service;
    }

    public function loadShoppingList()
    {
        $user = Auth::user();

        $this->listItems = GroceryListItem::with('groceryItem.category')
            ->where('grocery_list_id', $this->groceryListId)
            ->get()
            ->toArray(); // Ensures reactivity in Livewire
    }

    public function finalizeShopping()
    {
        // Update each item
        foreach ($this->listItems as $itemData) {
            $this->getService()->updateGroceryListItem($itemData['id'], [
                'purchased' => $itemData['purchased'] ?? false,
                'quantity' => $itemData['quantity'],
                'notes' => $itemData['notes'] ?? null,
            ]);
        }

        // Mark the grocery list as completed
        $groceryList = GroceryList::findOrFail($this->groceryListId);
        $groceryList->update(['status' => 'Completed']);

        // Add purchased items to stock
        $stockService = app(GroceryStockService::class);

        foreach ($this->listItems as $itemData) {
            if (!empty($itemData['purchased'])) {
                $stockService->addStock([
                    'household_id' => $groceryList->household_id,
                    'grocery_item_id' => $itemData['grocery_item']['id'],
                    'quantity' => $itemData['quantity'],
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('groceries.index')->with('success', 'Shopping finalized! Items have been added to your stock.');

    }

    public function increaseQty($index)
    {
        $this->listItems[$index]['quantity']++;
    }

    public function decreaseQty($index)
    {
        if ($this->listItems[$index]['quantity'] > 1) {
            $this->listItems[$index]['quantity']--;
        }
    }

    public function render()
    {
        return view('livewire.groceries.shopping-list');
    }
}
