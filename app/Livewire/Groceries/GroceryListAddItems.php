<?php

namespace App\Livewire\Groceries;

use App\Models\GroceryItem;
use App\Models\GroceryList;
use App\Models\GroceryListItem;
use App\Services\GroceryItemService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroceryListAddItems extends Component
{
    public int $groceryListId;
    public array $addItemData = [];
    public string $selectedCategory = '';
    public array $groupedItems = [];
    public string $itemName;
    public array $amount;
    public array $currentListItems = [];

    public array $categoryColors = [
        'Fruits' => 'bg-lime-400',
        'Vegetables' => 'bg-emerald-400',
        'Dairy' => 'bg-yellow-300',
        'Bakery' => 'bg-orange-400',
        'Meat' => 'bg-red-400',
        'Seafood' => 'bg-cyan-400',
        'Frozen Foods' => 'bg-sky-300',
        'Snacks' => 'bg-pink-400',
        'Beverages' => 'bg-indigo-400',
        'Condiments' => 'bg-amber-400',
        'Spices & Herbs' => 'bg-green-600',
        'Pantry Staples' => 'bg-gray-400',
        'Canned Goods' => 'bg-rose-400',
        'Grains & Pasta' => 'bg-yellow-500',
        'Baking Supplies' => 'bg-pink-300',
        'Breakfast & Cereal' => 'bg-amber-300',
        'Personal Care' => 'bg-violet-400',
        'Household Supplies' => 'bg-zinc-400',
        'Cleaning Products' => 'bg-slate-300',
        'Pet Supplies' => 'bg-rose-300',
        'Baby Products' => 'bg-fuchsia-400',
        'Health & Wellness' => 'bg-emerald-600',
        'Coffee & Tea' => 'bg-stone-400',
        'Sauces' => 'bg-amber-500',
        'Nuts & Seeds' => 'bg-yellow-600',
        'Oils & Vinegars' => 'bg-green-400',
        'Prepared Meals' => 'bg-red-300',
        'Deli' => 'bg-pink-500',
        'Toiletries' => 'bg-purple-400',
        'Paper Goods' => 'bg-gray-500',
        'International Foods' => 'bg-blue-500',
        'Gluten-Free' => 'bg-emerald-300',
        'Organic' => 'bg-green-300',
        'Vegan' => 'bg-lime-300',
        'Low-Carb/Keto' => 'bg-red-600',
        'Dips & Spreads' => 'bg-amber-600',
        'Cheese' => 'bg-yellow-400',
        'Eggs' => 'bg-orange-300',
        'Juices' => 'bg-cyan-300',
        'Energy Drinks' => 'bg-indigo-500',
        'Water' => 'bg-blue-300',
        'Alcohol' => 'bg-purple-500',

        // Optional extras
        'Seasonal Items' => 'bg-red-200',
        'Supplements' => 'bg-green-700',
        'Party Supplies' => 'bg-pink-600',
        'Ice Cream & Desserts' => 'bg-pink-200',
        'Cooking Essentials' => 'bg-yellow-200',
        'Specialty Foods' => 'bg-rose-500',
    ];

    public function mount(int $groceryListId)
    {
        $this->groceryListId = $groceryListId;

        $this->loadListItems();

        if (!empty($this->groupedItems)) {
            $this->selectedCategory = array_key_first($this->groupedItems);
        }

        $this->currentListItems = GroceryListItem::with('groceryItem')
            ->where('grocery_list_id', $this->groceryListId)
            ->get()
            ->toArray();
    }

    public function loadListItems()
    {
        $items = GroceryItem::with('category')->get();

        $itemsWithIcon = $items->map(function ($item) {
            return array_merge($item->toArray(), [
                'icon' => $item->category->icon ?? '🧺',
            ]);
        });

        $this->groupedItems = $itemsWithIcon
            ->groupBy(fn ($item) => $item['category']['name'] ?? 'Uncategorized')
            ->toArray();

        $currentColors = $this->categoryColors;

        $newColors = collect(array_keys($this->groupedItems))->mapWithKeys(function ($categoryName) use ($currentColors) {
            return [$categoryName => $currentColors[$categoryName] ?? $this->randomColor()];
        })->toArray();

        $this->categoryColors = $newColors;

        // ✅ Load current grocery list items
        $this->currentListItems = GroceryListItem::with('groceryItem')
            ->where('grocery_list_id', $this->groceryListId)
            ->get()
            ->toArray();
    }
    public function removeItemFromList(int $itemId)
    {
        GroceryListItem::where('id', $itemId)
            ->where('grocery_list_id', $this->groceryListId)
            ->delete();

        $this->loadListItems();

        session()->flash('success', 'Item removed from grocery list.');
    }


    public function getAmount($itemId)
    {
        return GroceryListItem::where('grocery_list_id', $this->groceryListId)
            ->where('grocery_item_id', $itemId)
            ->value('quantity');
    }

    public function incrementQuantity(int $itemId)
    {
        if (!isset($this->addItemData[$itemId]['quantity'])) {
            $this->addItemData[$itemId]['quantity'] = 1;
        } else {
            $this->addItemData[$itemId]['quantity']++;
        }
    }

    public function decrementQuantity(int $itemId)
    {
        if (!isset($this->addItemData[$itemId]['quantity'])) {
            $this->addItemData[$itemId]['quantity'] = 1;
        } elseif ($this->addItemData[$itemId]['quantity'] > 1) {
            $this->addItemData[$itemId]['quantity']--;
        }
    }

    public function addItemToList(int $itemId)
    {
        $data = $this->addItemData[$itemId] ?? [];
        $quantity = max((int) ($data['quantity'] ?? 1), 1);
        $brand = $data['brand'] ?? null;
        $notes = $data['notes'] ?? null;

        $existing = GroceryListItem::where('grocery_list_id', $this->groceryListId)
            ->where('grocery_item_id', $itemId)
            ->first();

        if ($existing) {
            $existing->quantity += $quantity;
            if ($brand) {
                $existing->brand = $brand;
            }
            $existing->save();
        } else {
            GroceryListItem::create([
                'grocery_list_id' => $this->groceryListId,
                'grocery_item_id' => $itemId,
                'quantity' => $quantity,
                'brand' => $brand,
                'notes' => $notes,
                'added_manually' => false,
                'purchased' => false,
            ]);
        }

        unset($this->addItemData[$itemId]);

        $this->loadListItems();

        session()->flash('success', 'Item added to grocery list!');
    }
    public function addNewItemToCategory($categoryId)
    {
        //getting household
        $user = Auth::user();
       $householdId = $user->household->id;
       $name = trim($this->itemName);
        app(GroceryItemService::class)->addGroceryItem(
            $name,
            $categoryId,
            $user->id,
            $user->household_id
        );

        $this->itemName  = '';
       $this->loadListItems();

       session()->flash('success', 'Item added to grocery list!');
    }

    public function render()
    {
        return view('livewire.groceries.grocery-list-add-items');
    }

    private function randomColor(): string
    {
        $colors = [
            'bg-indigo-100',
            'bg-blue-100',
            'bg-green-100',
            'bg-yellow-100',
            'bg-pink-100',
            'bg-purple-100',
            'bg-red-100',
            'bg-gray-100',
        ];

        return $colors[array_rand($colors)];
    }
}
